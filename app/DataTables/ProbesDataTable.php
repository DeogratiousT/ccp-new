<?php

namespace App\DataTables;

use App\Models\Probe;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProbesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Probe> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('indexCol', function () {
                static $indexCol = 0;
                return ++$indexCol;
            })
            ->addColumn('section', function (Probe $probe) {
                return view('dashboard.probes.index_section', compact('probe'));
            })
            ->addColumn('action', function (Probe $probe) {
                return view('dashboard.probes.index_action', compact('probe'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Probe>
     */
    public function query(Probe $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('probes-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => [],
            ])
            ->drawCallback('
                function() {
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    api.column(0).nodes().each(function(cell, i) {
                        cell.innerHTML = startIndex + i + 1;
                    });
                }
            ');

        return $this->addButtons($dataTable);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('indexCol')
                ->title('#')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false)
                ->printable(false)
                ->exportable(false),
            Column::make('uuid')
                ->addClass('ps-2'),
            Column::make('max_threshold'),
            Column::make('min_threshold'),
            Column::computed('section')
                ->exportable(false)
                ->printable(false)
                ->width('auto')
                ->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width('auto')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Probes_' . date('YmdHis');
    }

     /**
     * Add buttons
     */
    protected function addButtons($dataTable)
    {
        return $dataTable->buttons([
            'create' => [
                'className' => 'btn btn-success',
                'text' => '+ New',
                'action' => 'function () {
                    window.location.href = "'.route('dashboard.probes.create').'";
                }',
            ],
            'csv', 'excel', 'print'
        ]);
    }
}
