import React, { Fragment } from "react";
import { Link, useLocation } from "react-router-dom";

const ArticleNav = () => {
    const location = useLocation();
    return (
        <Fragment>
            <div className="row">
                <div className="col-sm-9">
                    <nav className="navbar navbar-expand-lg navbar-light bg-light">
                        <div className="container-fluid">
                            <nav aria-label="breadcrumb">
                                <ol className="breadcrumb">
                                    <li className="breadcrumb-item">
                                        <Link to={`/`}>
                                            <strong>
                                                <span
                                                    className={`text-${
                                                        location.pathname ===
                                                        "/"
                                                            ? "dark"
                                                            : "grey"
                                                    }`}
                                                >
                                                    Articles
                                                </span>
                                            </strong>
                                        </Link>
                                    </li>
                                    <li className="breadcrumb-item">
                                        <Link to={`/create`}>
                                            <strong>
                                                <span
                                                    className={`text-${
                                                        location.pathname ===
                                                        "/create"
                                                            ? "dark"
                                                            : "grey"
                                                    }`}
                                                >
                                                    Create Aricle
                                                </span>
                                            </strong>
                                        </Link>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </nav>
                </div>
            </div>
        </Fragment>
    );
};

export default ArticleNav;
