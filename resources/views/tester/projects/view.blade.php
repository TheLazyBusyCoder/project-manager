@extends('layout.tester-layout')

@section('head')
<link rel="stylesheet" href="{{ asset('css/vis.min.css') }}">
<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
<script src="{{ asset('js/vis.min.js') }}"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endsection

@section('main')

<div class="container" style="display:flex; gap:20px;">
    
    <!-- Tree -->
    <div style="width:45%;">
        <h3>Project Structure</h3>
        <div id="projectTree" style="height:500px;border:1px solid #ddd;"></div>
    </div>

    <!-- Documentation -->
    <div style="width:55%;">
        <h3 id="docTitle">Documentation</h3>
        <div id="docViewer" style="height:460px;"></div>
    </div>

</div>

@endsection

@section('script')
    <script>
        const nodes = new vis.DataSet(@json($nodes));
        const edges = new vis.DataSet(@json($edges));

        const container = document.getElementById('projectTree');

        const network = new vis.Network(container, {
            nodes,
            edges
        }, {
            layout: {
                hierarchical: {
                    direction: 'UD',
                    sortMethod: 'directed'
                }
            },
            physics: false
        });

        // Read-only Quill
        const quill = new Quill('#docViewer', {
            theme: 'snow',
            readOnly: true
        });

        network.on("click", function (params) {
            if (!params.nodes.length) return;

            const node = nodes.get(params.nodes[0]);

            if (node.data && node.data.doc) {
                document.getElementById('docTitle').innerText =
                    node.data.title || 'Documentation';

                quill.root.innerHTML = node.data.doc;
            } else {
                quill.root.innerHTML =
                    '<p style="color:#888">No documentation available.</p>';
            }
        });
    </script>

@endsection