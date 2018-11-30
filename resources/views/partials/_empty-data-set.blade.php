<div id="empty-list-view" class="card" style="max-width:700px;margin:5px auto;padding:25px 10px;">
  <div class="card-body text-center">
    @isset($emptySetHeaderShow)
      <h3 class="card-title">No Results</h3>
    @endisset
    @if($emptySetInfo !== null && $emptySetInfo !== '')
      <p class="card-text">{{ $emptySetInfo }}</p>
    @else
      <p class="card-text">Sorry, no results were found.</p>
    @endif
  </div>
</div>
