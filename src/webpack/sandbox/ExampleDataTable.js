"use strict";

import React from "react";
import DataTable from "react-data-table-component";

export class ExampleDataTable extends React.Component
{
    constructor(props)
    {
        super(props);
    }

    render()
    {
        return (
            <DataTable
                columns={this.props.columns}
                data={this.props.data}
                striped={true}
            />
        )
    }

}
