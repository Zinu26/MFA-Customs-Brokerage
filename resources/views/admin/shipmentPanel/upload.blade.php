<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $shipment->id }}"><i
        class="fa fa-upload"></i></button>

<div class="modal fade bd-example-modal-md" id="uploadModal{{ $shipment->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Files</h1>
            </div>
            <form action="{{route('upload_files')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $shipment->id }}" />

                    <div class="mb-3">
                        <input class="form-control" type="file" id="formFileMultiple" name="files[]"
                            style="font-weight: 500; padding: 0; font-size: 20px;" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
