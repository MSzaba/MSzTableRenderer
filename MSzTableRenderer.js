function mszTableFilter(table) {
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

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".mszColumnFilter").forEach(function (input) {
        input.addEventListener("input", function () {
            var table = input.closest("table");
            if (table) mszTableFilter(table);
        });
    });

    document.querySelectorAll("div.mszTableScroll[data-max-rows]").forEach(function (wrapper) {
        var maxRows = parseInt(wrapper.getAttribute("data-max-rows"));
        var table = wrapper.querySelector("table");
        if (!table) return;
        var rows = table.querySelectorAll("tbody tr");
        if (rows.length <= maxRows) return;
        var height = 0;
        var thead = table.querySelector("thead");
        if (thead) height += thead.getBoundingClientRect().height;
        for (var i = 0; i < maxRows; i++) {
            height += rows[i].getBoundingClientRect().height;
        }
        wrapper.style.maxHeight = Math.ceil(height) + "px";
        wrapper.style.overflowY = "auto";
    });
});
