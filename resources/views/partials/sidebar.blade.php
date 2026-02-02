<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

      <style>
.jstree-search {
    color: #22c55e !important;
    font-weight: 600;
}
</style>


<input
    type="text"
    id="tree-search"
    placeholder="Search modules..."
    style="width:100%; padding:8px; margin-bottom:10px;"
>
<div id="modules-tree"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jstree/dist/jstree.min.js"></script>

<script>
const treeData = @json($treeData ?? []);

$('#modules-tree').jstree({
    core: {
        data: treeData,
        themes: {
            variant: 'large'
        }
    },
    types: {
        default: { icon: 'fa fa-folder text-yellow-400' },
        file: { icon: 'fa fa-file text-blue-400' }
    },
    search: {
        case_sensitive: false,
        show_only_matches: true,
        show_only_matches_children: true
    },
    plugins: ['types', 'wholerow' , 'search']
});

$('#modules-tree').on('select_node.jstree', function (e, data) {
    const link = data.node.a_attr?.href;
    if (link) window.location.href = link;
});

let to = false;

$('#tree-search').keyup(function () {
    if (to) {
        clearTimeout(to);
    }
    to = setTimeout(function () {
        const v = $('#tree-search').val();
        $('#modules-tree').jstree(true).search(v);
    }, 250);
});
</script>
