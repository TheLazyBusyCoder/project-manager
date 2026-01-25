@section('title', 'Developer Details')
@extends('layout.project_manager-layout')


@section('head')
    <link rel="stylesheet" href="{{asset('css/vis.min.css')}}">
    <script src="{{asset('js/vis.min.js')}}"></script>
@endsection

@section('main')

<style>
    .container {
        max-width: 900px;
        margin: 10px auto;
        font-family: Arial, sans-serif;
    }

    .card {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .btn {
        padding: 6px 12px;
        border: 1px solid #333;
        background: #fff;
        font-size: 13px;
        margin-right: 5px;
        text-decoration: none;
        color: #333;
    }

    .btn:hover {
        background: #f5f5f5;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background: #f9f9f9;
    }

    .status-active {
        color: green;
    }

    .status-inactive {
        color: red;
    }
</style>

<div class="container">
    <div class="card">
        <div id="network" style="width:100%; height:400px;"></div>
    </div>
</div>

<script>
  const nodes = new vis.DataSet([
    {
      id: 1,
      label: 'Admin',
      shape: 'box',
      color: '#ffeaa7',
      font: { size: 16, align: 'center' },
      margin: 12
    },
    {
      id: 2,
      label: 'Project\nManager',
      shape: 'box',
      color: '#74b9ff',
      font: { size: 15, align: 'center' },
      widthConstraint: { minimum: 130, maximum: 160 },
      margin: 12
    },
    {
      id: 3,
      label: 'Developer',
      shape: 'ellipse',
      color: '#55efc4',
      font: { size: 14 }
    },
    {
      id: 4,
      label: 'Tester',
      shape: 'ellipse',
      color: '#81ecec',
      font: { size: 14 }
    },
    {
      id: 5,
      label: 'Bug\nTracking\nSystem',
      shape: 'box',
      color: '#fab1a0',
      font: { size: 14, align: 'center' },
      widthConstraint: { minimum: 150 },
      margin: 14
    },
    {
      id: 6,
      label: 'Bug\nReport',
      shape: 'box',
      color: '#fdcb6e',
      font: { size: 13, align: 'center' },
      margin: 10
    }
  ]);

  const edges = new vis.DataSet([
    { from: 1, to: 2, arrows: 'to', label: 'creates projects' },
    { from: 2, to: 3, arrows: 'to', label: 'assigns tasks' },
    { from: 2, to: 4, arrows: 'to', label: 'assigns tests' },
    { from: 3, to: 5, arrows: 'to', label: 'fixes bugs' },
    { from: 4, to: 6, arrows: 'to', label: 'reports bugs' },
    { from: 6, to: 5, arrows: 'to', label: 'stored in' }
  ]);

  const container = document.getElementById('network');

  const data = { nodes, edges };

  const options = {
    layout: {
      hierarchical: {
        direction: 'UD',
        sortMethod: 'directed',
        levelSeparation: 120,
        nodeSpacing: 150
      }
    },
    nodes: {
      borderWidth: 1,
      shadow: true
    },
    edges: {
      font: {
        align: 'middle',
        size: 12
      },
      smooth: true
    },
    interaction: {
      hover: true,
      dragNodes: true
    },
    physics: false
  };

  new vis.Network(container, data, options);
</script>
@endsection
