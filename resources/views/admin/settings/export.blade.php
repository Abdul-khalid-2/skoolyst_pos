<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('export.products') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Export Format</label>
                        <select class="form-control" name="format" required>
                            <option value="csv">CSV</option>
                            <option value="xlsx">Excel (XLSX)</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="includeVariants" name="include_variants" value="1" checked>
                            <label class="custom-control-label" for="includeVariants">Include Product Variants</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Export Products</button>
                </div>
            </form>
        </div>
    </div>
</div>