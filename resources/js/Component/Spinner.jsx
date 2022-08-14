import React, { Fragment } from "react";

const Spinner = () => {
    return (
        <Fragment>
            <div className="text-center">
                <div className="spinner-grow" role="status">
                    <span className="sr-only">Loading...</span>
                </div>
            </div>
        </Fragment>
    );
};

export default Spinner;
