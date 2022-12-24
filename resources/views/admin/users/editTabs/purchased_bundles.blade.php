<div class="tab-pane mt-3 fade" id="purchased_bundles" role="tabpanel" aria-labelledby="purchased_bundles-tab">
    <div class="row">

        @can('admin_enrollment_add_student_to_items')
            <div class="col-12 col-md-6">
                <h5 class="section-title after-line">{{ trans('update.add_student_to_bundle') }}</h5>

                <form action="/admin/enrollments/store" method="Post">

                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label class="input-label">{{trans('update.bundle')}}</label>
                        <select name="bundle_id" class="form-control search-bundle-select2"
                                data-placeholder="{{ trans('update.search_bundle') }}">

                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class=" mt-4">
                        <button type="button" class="js-save-manual-add btn btn-primary">{{ trans('admin/main.submit') }}</button>
                    </div>
                </form>
            </div>
        @endcan

        <div class="col-12">
            <div class="mt-5">
                <h5 class="section-title after-line">{{ trans('update.manual_added_bundles') }}</h5>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-md">
                        <tr>
                            <th>{{trans('update.bundle')}}</th>
                            <th>{{ trans('admin/main.type') }}</th>
                            <th>{{ trans('admin/main.price') }}</th>
                            <th>{{ trans('admin/main.instructor') }}</th>
                            <th class="text-center">{{ trans('update.added_date') }}</th>
                            <th class="text-right">{{ trans('admin/main.actions') }}</th>
                        </tr>

                        @if(!empty($manualAddedBundles))
                            @foreach($manualAddedBundles as $manualAddedBundle)

                                <tr>
                                    <td width="25%">
                                        <a href="{{ $manualAddedBundle->bundle->getUrl() }}" target="_blank" class="">{{ $manualAddedBundle->bundle->title }}</a>
                                    </td>

                                    <td>
                                        {{ trans('admin/main.'.$manualAddedBundle->bundle->type) }}
                                    </td>
                                    <td>{{ !empty($manualAddedBundle->bundle->price) ? handlePrice($manualAddedBundle->bundle->price) : '-' }}</td>
                                    <td width="25%">
                                        <p>{{ $manualAddedBundle->bundle->teacher->full_name  }}</p>
                                    </td>
                                    <td class="text-center">{{ dateTimeFormat($manualAddedBundle->created_at,'j M Y | H:i') }}</td>
                                    <td class="text-right">
                                        @can('admin_enrollment_block_access')
                                            @include('admin.includes.delete_button',[
                                                    'url' => '/admin/enrollments/'. $manualAddedBundle->id .'/block-access',
                                                    'tooltip' => trans('update.block_access'),
                                                    'btnIcon' => 'fa-times-circle'
                                                ])
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <p class="font-12 text-gray mt-1 mb-0">{{ trans('update.manual_add_hint') }}</p>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="mt-5">
                <h5 class="section-title after-line">{{ trans('update.manual_disabled_bundles') }}</h5>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-md">
                        <tr>
                            <th>{{trans('update.bundle')}}</th>
                            <th>{{ trans('admin/main.type') }}</th>
                            <th>{{ trans('admin/main.price') }}</th>
                            <th>{{ trans('admin/main.instructor') }}</th>
                            <th class="text-right">{{ trans('admin/main.actions') }}</th>
                        </tr>

                        @if(!empty($manualDisabledBundles))
                            @foreach($manualDisabledBundles as $manualDisabledBundle)

                                <tr>
                                    <td width="25%">
                                        <a href="{{ $manualDisabledBundle->bundle->getUrl() }}" target="_blank" class="">{{ $manualDisabledBundle->bundle->title }}</a>
                                    </td>

                                    <td>
                                        {{ trans('admin/main.'.$manualDisabledBundle->bundle->type) }}
                                    </td>
                                    <td>{{ !empty($manualDisabledBundle->bundle->price) ? handlePrice($manualDisabledBundle->bundle->price) : '-' }}</td>
                                    <td width="25%">
                                        <p>{{ $manualDisabledBundle->bundle->teacher->full_name  }}</p>
                                    </td>
                                    <td class="text-right">
                                        @can('admin_enrollment_block_access')
                                            @include('admin.includes.delete_button',[
                                                    'url' => '/admin/enrollments/'. $manualDisabledBundle->id .'/enable-access',
                                                    'tooltip' => trans('update.enable-student-access'),
                                                ])
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <p class="font-12 text-gray mt-1 mb-0">{{ trans('update.manual_remove_hint') }}</p>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="mt-5">
                <h5 class="section-title after-line">{{ trans('panel.purchased') }}</h5>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-md">
                        <tr>
                            <th>{{trans('update.bundle')}}</th>
                            <th>{{ trans('admin/main.type') }}</th>
                            <th>{{ trans('admin/main.price') }}</th>
                            <th>{{ trans('admin/main.instructor') }}</th>
                            <th class="text-center">{{ trans('panel.purchase_date') }}</th>
                            <th>{{ trans('admin/main.actions') }}</th>
                        </tr>

                        @if(!empty($purchasedBundles))
                            @foreach($purchasedBundles as $purchasedBundle)

                                <tr>
                                    <td width="25%">
                                        <a href="{{ $purchasedBundle->bundle->getUrl() }}" target="_blank" class="">{{ $purchasedBundle->bundle->title }}</a>
                                    </td>
                                    <td>
                                        {{ trans('admin/main.'.$purchasedBundle->bundle->type) }}
                                    </td>
                                    <td>{{ !empty($purchasedBundle->bundle->price) ? handlePrice($purchasedBundle->bundle->price) : '-' }}</td>
                                    <td width="25%">
                                        <p>{{ $purchasedBundle->bundle->teacher->full_name  }}</p>
                                    </td>
                                    <td class="text-center">{{ dateTimeFormat($purchasedBundle->created_at,'j M Y | H:i') }}</td>
                                    <td class="text-right">
                                        @can('admin_enrollment_block_access')
                                            @include('admin.includes.delete_button',[
                                                    'url' => '/admin/enrollments/'. $purchasedBundle->id .'/block-access',
                                                    'tooltip' => trans('update.block_access'),
                                                    'btnIcon' => 'fa-times-circle'
                                                ])
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <p class="font-12 text-gray mt-1 mb-0">{{ trans('update.purchased_hint') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
