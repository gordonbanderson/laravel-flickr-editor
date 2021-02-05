import React from 'react';
import {Helmet} from 'react-helmet';
import {VictoryBar, VictoryLabel} from "victory";

function OrphanedPanel(props)  {


    return <div>
        <Helmet><title>Orphaned Images</title></Helmet>
           <h1>Orphaned images</h1>
        <VictoryBar
            style={{ data: { fill: "#aaa" } }}
            data={[
                {x: 1, y: 3, label: "Alpha"},
                {x: 2, y: 4, label: "Bravo"},
                {x: 3, y: 6, label: "Charlie"},
                {x: 4, y: 3, label: "Delta"},
                {x: 5, y: 7, label: "Echo"},
            ]}
            labelComponent={
                <VictoryLabel angle={45} verticalAnchor="middle" textAnchor="end"/>
            }
        />
        </div>
    ;
}

export default OrphanedPanel;
