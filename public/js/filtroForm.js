document.getElementById("toggleFilterForm").addEventListener("click", function() {
    var form = document.getElementById("filterForm");
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
});
