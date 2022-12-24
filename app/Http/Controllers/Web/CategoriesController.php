<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FeatureWebinar;
use App\Models\Sale;
use App\Models\Ticket;
use App\Models\Translation\CategoryTranslation;
use App\Models\Webinar;
use App\Models\WebinarFilterOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(Request $request, $categoryTitle, $subCategoryTitle = null)
    {

        if (!empty($categoryTitle)) {

            $categoryTranslation = CategoryTranslation::where('title', str_replace('-', ' ', $categoryTitle))->first();

            $subCategoryTranslation = null;

            if (!empty($subCategoryTitle)) {
                $subCategoryTranslation = CategoryTranslation::where('title', str_replace('-', ' ', $subCategoryTitle))->get();
            }

            if (!empty($categoryTranslation)) {
                $category = Category::where(function ($query) use ($categoryTranslation, $subCategoryTranslation) {
                    if (!empty($subCategoryTranslation)) {
                        $query->whereIn('id', $subCategoryTranslation->pluck('category_id')->toArray());
                        $query->where('parent_id', $categoryTranslation->category_id);
                    } else {
                        $query->where('id', $categoryTranslation->category_id);
                    }
                })->withCount('webinars')
                    ->with(['filters' => function ($query) {
                        $query->with('options');
                    }])
                    ->first();
            }

            if (!empty($category)) {
                $featureWebinars = FeatureWebinar::whereIn('page', ['categories', 'home_categories'])
                    ->where('status', 'publish')
                    ->whereHas('webinar', function ($q) use ($category) {
                        $q->where('status', Webinar::$active);
                        $q->whereHas('category', function ($q) use ($category) {
                            $q->where('id', $category->id);
                        });
                    })
                    ->with(['webinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }, 'reviews', 'tickets', 'feature']);
                    }])
                    ->orderBy('updated_at', 'desc')
                    ->get();


                $webinarsQuery = Webinar::where('webinars.status', 'active')
                    ->where('private', false)
                    ->where('category_id', $category->id);

                $classesController = new ClassesController();
                $webinarsQuery = $classesController->handleFilters($request, $webinarsQuery);

                $sort = $request->get('sort', null);

                if (empty($sort)) {
                    $webinarsQuery = $webinarsQuery->orderBy('webinars.created_at', 'desc')
                        ->orderBy('webinars.updated_at', 'desc');
                }

                $webinars = $webinarsQuery->with(['tickets', 'feature'])
                    ->paginate(6);

                $seoSettings = getSeoMetas('categories');
                $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('site.categories_page_title');
                $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('site.categories_page_title');
                $pageRobot = getPageRobot('categories');

                $data = [
                    'pageTitle' => $pageTitle,
                    'pageDescription' => $pageDescription,
                    'pageRobot' => $pageRobot,
                    'category' => $category,
                    'webinars' => $webinars,
                    'featureWebinars' => $featureWebinars,
                    'webinarsCount' => $webinars->total(),
                    'sortFormAction' => $category->getUrl(),
                ];

                return view(getTemplate() . '.pages.categories', $data);
            }
        }

        abort(404);
    }
}
