@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inventory</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Amazon Sub-Category!</li>
                    </ol>
                </div>
                <h4 class="page-title">Amazon Sub-Category!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add New</button>
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Referral Fee</th>
                        <th>Size Tier Type</th>
                        <th>Shipping Weight</th>
                        <th>FBA Fee</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($amazonSubCategory as $key=>$amazonSubCategoryData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>...</td>
                            <td>{{$amazonSubCategoryData->name}}</td>
                            <td>{{$amazonSubCategoryData->referral_fee}}</td>
                            <td>{{$amazonSubCategoryData->size_tier_type}}</td>
                            <td>{{$amazonSubCategoryData->shipping_weight}}</td>
                            <td>{{$amazonSubCategoryData->fba_fee}}</td>
                            <td>{{$amazonSubCategoryData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$amazonSubCategoryData->id}}">Edit</button>
                                    <a href="{{route('amazon.sub.category.destroy',$amazonSubCategoryData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$amazonSubCategoryData->id}}">Delete</a>
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$amazonSubCategoryData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$amazonSubCategoryData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$amazonSubCategoryData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('amazon.sub.category.update',$amazonSubCategoryData->id)}}">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label  class="form-label">Amazon Category</label>
                                                            <select name="amazon_category_id" class="form-select">
                                                                @foreach($amazonCategory as $amazonCategoryData)
                                                                    <option value="{{$amazonCategoryData->id}}" {{ $amazonSubCategoryData->amazon_category_id === $amazonCategoryData->id ? 'selected' : '' }}>{{$amazonCategoryData->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name" value="{{$amazonSubCategoryData->name}}"
                                                                   class="form-control" placeholder="Enter  Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="referral_fee" class="form-label">Referral Fee</label>
                                                            <input type="text" id="referral_fee" name="referral_fee" value="{{$amazonSubCategoryData->referral_fee}}"
                                                                   class="form-control" placeholder="Enter  Referral Fee" required>
                                                        </div>
                                                    </div>


                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="size_tier_type" class="form-label">Size Tier Type</label>
                                                            <select name="size_tier_type" class="form-select">
                                                                <option value="Small Standard" {{ $amazonSubCategoryData->size_tier_type === 'Small Standard' ? 'selected' : '' }}>Small Standard</option>
                                                                <option value="Large Standard" {{ $amazonSubCategoryData->size_tier_type === 'Large Standard' ? 'selected' : '' }}>Large Standard</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="shipping_weight" class="form-label">Shipping Weight</label>
                                                            <input type="text" id="shipping_weight" name="shipping_weight" value="{{$amazonSubCategoryData->shipping_weight}}"
                                                                   class="form-control" placeholder="Enter Shipping Weight" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="fba_fee" class="form-label">FBA Fee</label>
                                                            <input type="text" id="fba_fee" name="fba_fee" value="{{$amazonSubCategoryData->fba_fee}}"
                                                                   class="form-control" placeholder="Enter  FBA Fee" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1" {{ $amazonSubCategoryData->status === 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $amazonSubCategoryData->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Delete Modal -->
                            <div id="danger-header-modal{{$amazonSubCategoryData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$amazonSubCategoryData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$amazonSubCategoryData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('amazon.sub.category.destroy',$amazonSubCategoryData->id)}}" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('amazon.sub.category.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-2">
                                    <label  class="form-label">Amazon Category</label>
                                    <select name="amazon_category_id" class="form-select">
                                        @foreach($amazonCategory as $amazonCategoryData)
                                            <option value="{{$amazonCategoryData->id}}">{{$amazonCategoryData->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name"
                                           class="form-control" placeholder="Enter  Name" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="referral_fee" class="form-label">Referral Fee</label>
                                    <input type="text" id="referral_fee" name="referral_fee"
                                           class="form-control" placeholder="Enter  Referral Fee" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="size_tier_type" class="form-label">Size Tier Type</label>
                                    <select name="size_tier_type" class="form-select">
                                        <option value="Small Standard">Small Standard</option>
                                        <option value="Large Standard">Large Standard</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="shipping_weight" class="form-label">Shipping Weight</label>
                                    <input type="text" id="shipping_weight" name="shipping_weight"
                                           class="form-control" placeholder="Enter Shipping Weight" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-2">
                                    <label for="fba_fee" class="form-label">FBA Fee</label>
                                    <input type="text" id="fba_fee" name="fba_fee"
                                           class="form-control" placeholder="Enter  FBA Fee" required>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
