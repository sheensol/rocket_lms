<div class="tab-pane mt-3 fade" id="purchased_courses" role="tabpanel" aria-labelledby="purchased_courses-tab">
    <div class="row">

        @can('admin_enrollment_add_student_to_items')
            <div class="col-12 col-md-6">
                <h5 class="section-title after-line">{{ trans('update.add_student_to_course') }}</h5>

                <form action="/admin/enrollments/store" method="Post">

                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label class="input-label">{{trans('admin/main.class')}}</label>
                        <select name="webinar_id" class="form-control search-webinar-select2"
                                data-placeholder="{{trans('panel.choose_webinar')}}">

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
                <h5 class="section-title after-line">{{ trans('update.manual_added') }}</h5>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-md">
                        <tr>
                            <th>{{ trans('admin/main.class') }}</th>
                            <th>{{ trans('admin/main.type') }}</th>
                            <th>{{ trans('admin/main.price') }}</th>
                            <th>{{ trans('admin/main.instructor') }}</th>
                            <th class="text-center">{{ trans('update.added_date') }}</th>
                            <th class="text-right">{{ trans('admin/main.actions') }}</th>
                        </tr>

                        @if(!empty($manualAddedClasses))
                            @foreach($manualAddedClasses as $manualAddedClass)

                                <tr>
                                    <td width="25%">
                                        <a href="{{ $manualAddedClass->webinar->getUrl() }}" target="_blank" class="">{{ $manualAddedClass->webinar->title }}</a>
                                    </td>

                                    <td>
                                        {{ trans('admin/main.'.$manualAddedClass->webinar->type) }}
                                    </td>
                                    <td>{{ !empty($manualAddedClass->webinar->price) ? handlePrice($manualAddedClass->webinar->price) : '-' }}</td>
                                    <td width="25%">
                                        <p>{{ $manualAddedClass->webinar->teacher->full_name  }}</p>
                                    </td>
                                    <td class="text-center">{{ dateTimeFormat($manualAddedClass->created_at,'j M Y | H:i') }}</td>
                                    <td class="text-right">
                                        @can('admin_enrollment_block_access')
                                            @include('admin.includes.delete_button',[
                                                    'url' => '/admin/enrollments/'. $manualAddedClass->id .'/block-access',
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
                <h5 class="section-title after-line">{{ trans('update.manual_disabled') }}</h5>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-md">
                        <tr>
                            <th>{{ trans('admin/main.class') }}</th>
                            <th>{{ trans('admin/main.type') }}</th>
                            <th>{{ trans('admin/main.price') }}</th>
                            <th>{{ trans('admin/main.instructor') }}</th>
                            <th class="text-right">{{ trans('admin/main.actions') }}</th>
                        </tr>

                        @if(!empty($manualDisabledClasses))
                            @foreach($manualDisabledClasses as $manualDisabledClass)

                                <tr>
                                    <td width="25%">
                                        <a href="{{ $manualDisabledClass->webinar->getUrl() }}" target="_blank" class="">{{ $manualDisabledClass->webinar->title }}</a>
                                    </td>

                                    <td>
                                        {{ trans('admin/main.'.$manualDisabledClass->webinar->type) }}
                                    </td>
                                    <td>{{ !empty($manualDisabledClass->webinar->price) ? handlePrice($manualDisabledClass->webinar->price) : '-' }}</td>
                                    <td width="25%">
                                        <p>{{ $manualDisabledClass->webinar->teacher->full_name  }}</p>
                                    </td>
                                    <td class="text-right">
                                        @can('admin_enrollment_block_access')
                                            @include('admin.includes.delete_button',[
                                                    'url' => '/admin/enrollments/'. $manualDisabledClass->id .'/enable-access',
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
                            <th>{{ trans('admin/main.class') }}</th>
                            <th>{{ trans('admin/main.type') }}</th>
                            <th>{{ trans('admin/main.price') }}</th>
                            <th>{{ trans('admin/main.instructor') }}</th>
                            <th class="text-center">{{ trans('panel.purchase_date') }}</th>
                            <th>{{ trans('admin/main.actions') }}</th>
                        </tr>

                        @if(!empty($purchasedClasses))
                            @foreach($purchasedClasses as $purchasedClass)

                                <tr>
                                    <td width="25%">
                                        <a href="{{ $purchasedClass->webinar->getUrl() }}" target="_blank" class="">{{ $purchasedClass->webinar->title }}</a>
                                    </td>
                                    <td>
                                        {{ trans('admin/main.'.$purchasedClass->webinar->type) }}
                                    </td>
                                    <td>{{ !empty($purchasedClass->webinar->price) ? handlePrice($purchasedClass->webinar->price) : '-' }}</td>
                                    <td width="25%">
                                        <p>{{ $purchasedClass->webinar->teacher->full_name  }}</p>
                                    </td>
                                    <td class="text-center">{{ dateTimeFormat($purchasedClass->created_at,'j M Y | H:i') }}</td>
                                    <td class="text-right">
                                        @can('admin_enrollment_block_access')
                                            @include('admin.includes.delete_button',[
                                                    'url' => '/admin/enrollments/'. $purchasedClass->id .'/block-access',
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
