import React, { Fragment, useState, useEffect } from "react";
import { cusaxios, api_url } from "../config";
import { useNavigate } from "react-router-dom";
import Spinner from "../Component/Spinner";
// react select
import Select from "react-select";

const Article = () => {
    const [articles, setArticles] = useState([]);
    const [pageNum, setPagenNum] = useState(1);
    const [load, setLoad] = useState(false);
    const [search, setSearch] = useState("");
    const navigate = useNavigate();

    const [date, setDate] = useState();
    const [timestamp, setTimeStamp] = useState("timestamp");

    // react select
    const [options, setOptions] = useState([]);
    const [category, setCategory] = useState({});

    const user_id = window.auth.id;
    const [options2, setOptions2] = useState([
        { label: "all", value: "all" },
        { label: "me", value: "me" },
        { label: "others", value: "others" },
    ]);
    const [authorOption, setAuthorOption] = useState({
        label: "all",
        value: "all",
    });

    const [sortView, setSortView] = useState(false);
    const [testView, setTestView] = useState();
    const handleOnSortView = () => {
        setSortView(!sortView);
    };

    const fetchCategory = () => {
        cusaxios.get("/api/category-get").then(({ data }) => {
            if (data.success) {
                setOptions((oldOptions) => [
                    ...oldOptions,
                    ...data.data.options,
                ]);
            }
        });
    };

    const fetchArticles = () => {
        setLoad(true);
        cusaxios
            .get(
                `/api/article-get?search=${search}&category=${category.value}&authorOption=${authorOption.value}&user_id=${user_id}&sort_view=${sortView}&date=${date}&page=${pageNum}`
            )
            .then(({ data }) => {
                setArticles(data.data);
                setTimeStamp(data.timestamp);
                setLoad(false);
            });
    };

    const plusPage = () => {
        setPagenNum(pageNum + 1);
    };
    const minusPage = () => {
        if (pageNum > 1) {
            setPagenNum(pageNum - 1);
        }
        2;
    };

    const deleteArticle = (slug) => {
        const data = new FormData();
        data.append("slug", slug);
        cusaxios.post("/api/article-delete", data).then(({ data }) => {
            if (data.success) {
                var pArticle = { ...articles };
                pArticle.data = pArticle.data.filter((a) => a.slug !== slug);
                setArticles(pArticle);
                showToast(data.data, "info");
            }
        });
    };

    const updateArticle = (slug) => {
        navigate("/article", { state: { slug: slug } });
    };

    const makeFeature = (slug) => {
        const data = new FormData();
        data.append("slug", slug);
        cusaxios.post("/api/article-featured", data).then(({ data }) => {
            if (data.success) {
                var fArticle = { ...articles };
                fArticle.data.map((a) => {
                    if (a.featured === "true") {
                        a.featured = "false";
                    }
                    if (a.slug === slug) {
                        a.featured = "true";
                    }
                });
                setArticles(fArticle);
            }
        });
    };

    useEffect(() => {
        fetchArticles();
        fetchCategory();
    }, [pageNum]);

    return (
        <Fragment>
            <div className="row">
                <div className="col-sm-12">
                    {load && (
                        <div className="container mt-5">
                            <Spinner />
                        </div>
                    )}
                    {!load && (
                        <Fragment>
                            <div className="mt-3">
                                <div className="input-group">
                                    <div className="form-outline border">
                                        <input
                                            id="search-input"
                                            type="search"
                                            className="form-control"
                                            value={search}
                                            onChange={(e) => {
                                                setSearch(e.target.value);
                                            }}
                                        />
                                        <label
                                            className="form-label text-dark"
                                            htmlFor="form1"
                                        ></label>
                                    </div>
                                    <button
                                        id="search-button"
                                        type="button"
                                        className="btn btn-primary"
                                        onClick={() => {
                                            fetchArticles();
                                        }}
                                    >
                                        <i className="fas fa-search" />
                                    </button>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-sm-3">
                                    <h6 className="mt-3">Select Category</h6>
                                    <Select
                                        className="basic-single"
                                        classNamePrefix="select"
                                        name="color"
                                        options={options}
                                        onChange={setCategory}
                                    />
                                </div>
                                <div className="col-sm-3">
                                    <h6 className="mt-3">Written by</h6>
                                    <Select
                                        className="basic-single"
                                        classNamePrefix="select"
                                        name="color"
                                        options={options2}
                                        onChange={setAuthorOption}
                                        defaultValue={[options2[0]]}
                                    />
                                </div>
                                <div className="col-sm-2">
                                    <div
                                        className="form-check"
                                        style={{ marginTop: 48 }}
                                    >
                                        <input
                                            className="form-check-input"
                                            type="checkbox"
                                            id="flexCheckDefault"
                                            checked={sortView}
                                            onChange={handleOnSortView}
                                        />
                                        <label
                                            className="form-check-label"
                                            htmlFor="flexCheckDefault"
                                        >
                                            Sort by views
                                        </label>
                                    </div>
                                </div>
                                <div className="col-sm-3">
                                    <h6 className="mt-3">Select Date</h6>
                                    <input
                                        type="date"
                                        onChange={(e) => {
                                            setDate(e.target.value);
                                        }}
                                        value={date}
                                    />
                                </div>
                            </div>
                            <div className="card mt-3">
                                <div className="card-header bg-dark mt-3">
                                    <h4 className="text-white">Articles</h4>
                                </div>
                                <div className="card-body table-responsive">
                                    <table className="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Writer</th>
                                                <th>Categories</th>
                                                <th></th>
                                                <th></th>
                                                <th>Views</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {articles.data?.map(
                                                (article, i) => (
                                                    <tr key={article.id}>
                                                        <td>
                                                            {article.header
                                                                .file ===
                                                                "image" && (
                                                                <img
                                                                    src={
                                                                        api_url +
                                                                        article
                                                                            .header
                                                                            .file_path
                                                                    }
                                                                    height="80"
                                                                    alt={
                                                                        article.name
                                                                    }
                                                                />
                                                            )}
                                                            {article.header
                                                                .file ===
                                                                "video" && (
                                                                <div className="embed-responsive embed-responsive-16by9">
                                                                    <iframe
                                                                        className="embed-responsive-item"
                                                                        src={
                                                                            api_url +
                                                                            article
                                                                                .header
                                                                                .file_path
                                                                        }
                                                                    />
                                                                </div>
                                                            )}
                                                        </td>
                                                        <td>{article.name}</td>
                                                        <td>
                                                            {article.user.name}
                                                        </td>
                                                        <td>
                                                            {article.category.map(
                                                                (c, i) => (
                                                                    <a
                                                                        key={
                                                                            c.id
                                                                        }
                                                                        href={`/article-view-by-category/${c.slug}`}
                                                                    >
                                                                        <span
                                                                            className="badge badge-info"
                                                                            style={{
                                                                                marginRight:
                                                                                    "3px",
                                                                            }}
                                                                        >
                                                                            {
                                                                                c.name
                                                                            }
                                                                        </span>
                                                                    </a>
                                                                )
                                                            )}
                                                        </td>
                                                        <td>
                                                            <a
                                                                className="btn btn-sm btn-secondary"
                                                                style={{
                                                                    marginRight:
                                                                        "5px",
                                                                }}
                                                                href={`/article-view/${article.slug}`}
                                                            >
                                                                <i className="fa-solid fa-eye"></i>
                                                            </a>
                                                            <button
                                                                className="btn btn-sm btn-success"
                                                                style={{
                                                                    marginRight:
                                                                        "5px",
                                                                }}
                                                                onClick={() => {
                                                                    updateArticle(
                                                                        article.slug
                                                                    );
                                                                }}
                                                            >
                                                                <i className="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                            <button
                                                                className="btn btn-sm btn-danger"
                                                                onClick={() => {
                                                                    deleteArticle(
                                                                        article.slug
                                                                    );
                                                                }}
                                                            >
                                                                <i className="fa-solid fa-trash"></i>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {article.featured ===
                                                                "false" && (
                                                                <button
                                                                    onClick={() => {
                                                                        makeFeature(
                                                                            article.slug
                                                                        );
                                                                    }}
                                                                    className="btn btn-sm btn-light"
                                                                >
                                                                    Unfeatured
                                                                </button>
                                                            )}
                                                            {article.featured ===
                                                                "true" && (
                                                                <button
                                                                    className="btn btn-sm btn-success"
                                                                    disabled
                                                                >
                                                                    Featured
                                                                </button>
                                                            )}
                                                        </td>
                                                        <td>
                                                            {article.v_count}
                                                        </td>
                                                        <td>
                                                            {
                                                                article.article_created
                                                            }
                                                        </td>
                                                    </tr>
                                                )
                                            )}
                                        </tbody>
                                    </table>
                                    <div>
                                        <button
                                            className="btn btn-dark btn-rounded"
                                            disabled={
                                                articles.last_page_url
                                                    ? false
                                                    : true
                                            }
                                            style={{ marginRight: "5px" }}
                                            onClick={() => {
                                                minusPage();
                                            }}
                                        >
                                            <i className="fa-solid fa-angle-left"></i>
                                        </button>
                                        {articles.links?.map((l, i) => {
                                            if (
                                                l.label !==
                                                    "&laquo; Previous" &&
                                                l.label !== "Next &raquo;"
                                            ) {
                                                if (
                                                    parseInt(l.label) ==
                                                        pageNum ||
                                                    parseInt(l.label) ==
                                                        pageNum + 1
                                                )
                                                    return (
                                                        <button
                                                            key={i}
                                                            className={`btn btn-${
                                                                parseInt(
                                                                    l.label
                                                                ) == pageNum
                                                                    ? "outline-"
                                                                    : ""
                                                            }dark btn-rounded`}
                                                            style={{
                                                                marginRight:
                                                                    "5px",
                                                            }}
                                                            onClick={() => {
                                                                setPagenNum(
                                                                    parseInt(
                                                                        l.label
                                                                    )
                                                                );
                                                            }}
                                                        >
                                                            {l.label}
                                                        </button>
                                                    );
                                            }
                                        })}
                                        <button
                                            className="btn btn-dark btn-rounded"
                                            disabled={
                                                articles.next_page_url
                                                    ? false
                                                    : true
                                            }
                                            onClick={() => {
                                                plusPage();
                                            }}
                                        >
                                            <i className="fa-solid fa-angle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </Fragment>
                    )}
                </div>
            </div>
        </Fragment>
    );
};

export default Article;
