<button type="button" class="btn btn-secondary" data-bs-toggle="modal"
    data-bs-target="#viewFileModal{{ $shipment->id }}"><i class="fa fa-download"></i></button>

<div class="modal fade bd-example-modal-md" id="viewFileModal{{ $shipment->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mbc3" style="background-color: #4EA646">
                <h5 class="modal-title">ATTACHMENTS</h5>
                <a style="cursor: pointer;" data-bs-dismiss="modal"><i class="fa fa-xmark"></i></a>
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
                                        href="@if (Auth::user()->type == 'admin') {{ route('download_file', $file->id) }}@elseif(Auth::user()->type == 'employee'){{ route('download_file.employee', $file->id) }} @endif"><button
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
