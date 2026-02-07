{{-- jstree styles --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="card h-100">
    <div class="card-body p-3">

        <input
            type="text"
            id="tree-search"
            class="form-control form-control-sm mb-3"
            placeholder="Search modules..."
        >

        <div id="modules-tree"></div>
    </div>
</div>

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
        default: { icon: 'fa fa-folder text-warning' },
        file: { icon: 'fa fa-file text-primary' }
    },
    search: {
        case_sensitive: false,
        show_only_matches: true,
        show_only_matches_children: true
    },
    plugins: ['types', 'wholerow', 'search']
});

$('#modules-tree').on('select_node.jstree', function (e, data) {
    const link = data.node.a_attr?.href;
    if (link) window.location.href = link;
});

let to = false;
$('#tree-search').on('keyup', function () {
    clearTimeout(to);
    to = setTimeout(() => {
        $('#modules-tree').jstree(true).search(this.value);
    }, 250);
});
</script>
