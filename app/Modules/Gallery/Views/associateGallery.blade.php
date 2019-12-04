<style>
    .text-color-white {
        color: white !important;
    }
</style>

<!-- Modal -->
<div id="associateGalleryModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Associate this photo with Gallery</h4>
      </div>
      <div class="modal-body">
          <form action="{{ route('postAssociteGallery') }}" method='post'>
            <label>Select Gallery</label>
            <select class="form-control" name="associative_id" id="g_id">
                <option value="">Select Gallery</option>
                @foreach ($allGallery as $g_id => $value)

                    @if ($g_id !== $parentGallery['id'])
                        <option {{ (old('g_id') == $g_id) ? 'selected' : null }} value="{{ $g_id }}">{{ $value }}</option>
                    @endif    
                @endforeach
            </select>
            <br>
            @csrf
            <input type="hidden" class="photo-id" name="photo_id">
            <input type="hidden" class="gallery-id" name="g_id" value="{{ @reset($gallery)['id'] }}">
            <input type="submit" class="btn btn-info text-color-white" value="Save">
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@push('scripts')
<script>
$(function () {
        $('#associateGalleryModal').on('hidden.bs.modal', function () {
            $('.photo-id', this).val('');
        });
    });
</script>
@endpush