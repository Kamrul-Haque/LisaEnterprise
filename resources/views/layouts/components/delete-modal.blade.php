<div class="modal fade" id="delete{{$loop}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">Delete Confirmation</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body text-danger font-weight-bold">
                <h4>Do you really want to delete the record? All related information will be delete.</h4>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                <form {{ $slot }} method="post">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
