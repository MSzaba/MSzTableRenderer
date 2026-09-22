function mszTableFilter(tableId) {
    var table = document.getElementById(tableId);
    var inputs = table.querySelectorAll("thead tr.mszFilterRow input[data-col-index]");
    var rows = table.querySelectorAll("tbody tr");
    rows.forEach(function (row) {
        var cells = row.querySelectorAll("td");
        var visible = true;
        inputs.forEach(function (inp) {
            var val = inp.value.toLowerCase();
            if (val) {
                var colIdx = parseInt(inp.getAttribute("data-col-index"));
                if (cells[colIdx] && cells[colIdx].textContent.toLowerCase().indexOf(val) === -1) {
                    visible = false;
                }
            }
        });
        row.style.display = visible ? "" : "none";
    });
}
