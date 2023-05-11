<button type="button" class="btn btn-secondary" data-bs-toggle="modal"
    data-bs-target="#viewFileModal{{ $shipment->id }}"><i class="fa fa-download"></i></button>

<div class="modal fade bd-example-modal-md" id="viewFileModal{{ $shipment->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Attachments</h1>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        @if ($file->shipment_id == $shipment->id)
                            <tr>
                                <td>{{ $file->name }}</td>
                                <td><a href="{{ route('download_file', $file->id) }}"><button class="btn btn-secondary"><i class="fa fa-download"></i> Download</button></a></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
