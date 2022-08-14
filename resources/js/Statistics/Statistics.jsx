import React, { Fragment, useState, useEffect } from "react";
import { cusaxios } from "../config";
import Spinner from "../Component/Spinner";
// vicotry chart
import {
    VictoryBar,
    VictoryChart,
    VictoryTheme,
    VictoryPie,
    VictoryContainer,
} from "victory";
// rect select
import Select from "react-select";

const Statistics = () => {
    const [load, setLoad] = useState(true);
    // react select
    const [y, setY] = useState([]);
    const [yearOption, setYearOption] = useState([]);

    const yearsCal = () => {
        const years = [];
        var currentTime = new Date();
        for (var i = 2000; i <= parseInt(currentTime.getFullYear()); i++) {
            years.push({ label: i.toString(), value: i });
        }
        setYearOption(years.reverse());
    };
    // -----------

    // victory chart
    const [data, setData] = useState([]);
    const [curYear, setCurYear] = useState();
    const [viewCounts, setViewCounts] = useState([]);

    const getMonthlyView = () => {
        setLoad(true);
        cusaxios.get(`/api/get-statistics?year=${y.value}`).then(({ data }) => {
            setLoad(false);
            setData(data.data);
            setCurYear(data.year);
            setViewCounts(data.view_counts);
            setPieData(data.cat_pie);
            setPieLabel(data.cat_label);
        });
    };

    // victory pie chart
    const [pieData, setPieData] = useState([]);
    const [pieLabel, setPieLabel] = useState([]);

    // --------------

    useEffect(() => {
        yearsCal();
        getMonthlyView();
    }, [y]);
    return (
        <Fragment>
            <h3 className="text-center">
                <i className="fa-solid fa-chart-line"></i> Statistics
            </h3>
            {load && (
                <Fragment>
                    <div className="row">
                        <div className="col-sm-4"></div>
                        <div className="col-sm-4">
                            <Spinner />
                        </div>
                        <div className="col-sm-4"></div>
                    </div>
                </Fragment>
            )}
            {!load && (
                <Fragment>
                    <div className="row">
                        <div className="col-sm-3"></div>
                    </div>
                    <div className="row">
                        <div className="col-sm-6">
                            <div className="mt-3">
                                <strong>
                                    <p className="text-center">
                                        {curYear} Monthly View Bar Chart
                                    </p>
                                </strong>
                            </div>
                            <div className="row">
                                <div className="col-sm-3"></div>
                                <div className="col-sm-6">
                                    <strong>
                                        <span>Select year</span>
                                    </strong>
                                    <Select
                                        className="basic-single"
                                        classNamePrefix="select"
                                        name="year"
                                        options={yearOption}
                                        onChange={setY}
                                    />
                                </div>
                                <div className="col-sm-3"></div>
                            </div>

                            <VictoryChart
                                horizontal
                                theme={VictoryTheme.material}
                                domainPadding={{ x: 8 }}
                            >
                                <VictoryBar
                                    horizontal
                                    data={data}
                                    // data accessor for x values
                                    x="quarter"
                                    // data accessor for y values
                                    y="earnings"
                                    labels={viewCounts}
                                />
                            </VictoryChart>
                        </div>
                        <div className="col-sm-6">
                            <div className="mt-3">
                                <strong>
                                    <p className="text-center">
                                        Category view pie chart
                                    </p>
                                </strong>
                            </div>
                            <VictoryPie
                                data={pieData}
                                theme={VictoryTheme.material}
                                labelRadius={60}
                                style={{
                                    labels: {
                                        fill: "black",
                                        fontSize: 11,
                                        fontWeight: "bold",
                                    },
                                }}
                                labels={pieLabel}
                                labelPosition={"centroid"}
                            />
                        </div>
                    </div>
                </Fragment>
            )}
        </Fragment>
    );
};

export default Statistics;
