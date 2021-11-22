(function($) {
    /**
     * Create or Delete a Row of List
     */
    $.fn.listRowCd = function(options) {
        return this.each(function() {
            var _this = $(this);
            var opts = $.extend({}, $.fn.listRowCd.Default, options, _this.data());
            // delete button
            _this.find(opts.delBtn).on('click', function(e) {
                e.preventDefault();
                var _delBtn = $(this);
                var _row = _delBtn.parents(opts.row);
                _row.fadeToggle('slow', function() {
                    _row.remove();
                });
            });
            _this.find(opts.createBtn).on('click', function(e) {
                e.preventDefault();
                var _createBtn = $(this);
                var _rows = _this.find(opts.row);
                var _lastRow = $(_rows[_rows.length - 1]);
                _lastRow.clone(true).insertAfter(_lastRow);
            });
        });
    };

    $.fn.listRowCd.Default = {
        delBtn: '.btn-del',
        createBtn: '.btn-create',
        row: 'tr',
    };
})(jQuery);