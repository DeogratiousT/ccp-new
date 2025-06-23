<?php

namespace App\DataTables;

use App\Models\Section;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SectionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Section> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('indexCol', function () {
                static $indexCol = 0;
                return ++$indexCol;
            })
            ->addColumn('action', function (Section $section) {
                return view('dashboard.sections.index_action', compact('section'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Section>
     */
    public function query(Section $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('sections-table')
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
            Column::make('name')
                    ->addClass('ps-2'),
            Column::make('slug'),
            Column::make('rabbitmq_exchange'),
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
        return 'Sections_' . date('YmdHis');
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
                    window.location.href = "'.route('dashboard.sections.create').'";
                }',
            ],
            'csv', 'excel', 'print'
        ]);
    }
}
