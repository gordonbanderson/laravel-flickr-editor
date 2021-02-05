import React from 'react';
import {Helmet} from 'react-helmet';
import {VictoryBar, VictoryChart, VictoryTooltip, VictoryAxis} from "victory";
import {useQuery} from "@apollo/client";
import {GET_AMOUNT_OF_ORPHAN_PHOTOS_BY_DAY, GET_FLICKR_SET_LIST} from "../../constants";

function OrphanedPanel(props)  {
    const { loading, error, data } = useQuery(GET_AMOUNT_OF_ORPHAN_PHOTOS_BY_DAY);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);

    // @todo maybe try this https://formidable.com/open-source/victory/gallery/brush-and-zoom, note it has dates
    let amountsByDate = data.orphaned_photos_by_date;
    let graphData = [];
    for (let i=0; i< amountsByDate.length; i++) {
        let row = {x:i+1, y:amountsByDate[i].amount_of_photos, label: amountsByDate[i].date_of_photos};
        graphData.push(row);
    }


    return <div>
        <Helmet><title>Orphaned Images</title></Helmet>
           <h1>Orphaned images</h1>
        <VictoryChart>
            <VictoryAxis
                dependentAxis
                // tickFormat specifies how ticks should be displayed
                tickFormat={(x) => x}
            />
            <VictoryBar
                labelComponent={<VictoryTooltip/>}
                style={{ data: { fill: "#aaa" } }}
                data={graphData}
            />
        </VictoryChart>

        </div>
    ;
}

export default OrphanedPanel;
