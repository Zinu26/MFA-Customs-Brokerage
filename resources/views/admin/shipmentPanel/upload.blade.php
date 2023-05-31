<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $shipment->id }}"><i
        class="fa fa-upload"></i></button>

<div class="modal fade bd-example-modal-md" id="uploadModal{{ $shipment->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">UPLOAD FILES</h5>
                <a style="cursor: pointer;" data-bs-dismiss="modal"><i class="fa fa-xmark"></i></a>
            </div>
            <form
                action="@if (Auth::user()->type == 'admin') {{ route('upload_files') }}
                        @elseif(Auth::user()->type == 'employee'){{ route('upload_files.employee') }} @endif"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $shipment->id }}" />

                    <div class="mb-3">
                        <input class="form-control" type="file" id="formFileMultiple" name="files[]"
                            style="font-weight: 500; padding: 0; font-size: 20px;" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">UPLOAD</button>
                </div>
            </form>
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">ATTACHMENTS</h5>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="text-center">FILE NAME</th>
                        <th class="text-center">OPTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        @if ($file->shipment_id == $shipment->id)
                            <tr class="text-center">
                                <td>{{ $file->name }}</td>
                                <td><a
                                        href="@if (Auth::user()->type == 'admin') {{ route('download_file', $file->id) }}
                                        @elseif(Auth::user()->type == 'employee'){{ route('download_file.employee', $file->id) }} @endif"><button
                                            class="btn btn-secondary"><i class="fas fa-download"></i>
                                            DOWNLOAD</button></a></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
