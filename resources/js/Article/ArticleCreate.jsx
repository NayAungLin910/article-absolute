import React, { useState, Fragment, useEffect } from "react";
import { cusaxios } from "../config";
import { useNavigate } from "react-router-dom";
import Spinner from "../Component/Spinner";
// react quill
import ReactQuill from "react-quill";
import "react-quill/dist/quill.snow.css";
// react select
import Select from "react-select";
import makeAnimated from "react-select/animated";


const ArticleCreate = () => {
    const [error, setError] = useState();
    const navigate = useNavigate();

    // data
    const [name, setName] = useState("");
    const [file, setFile] = useState();
    const [res, setRes] = useState();
    const [category, setCategory] = useState([]);
    const [load, setLoad] = useState(false);

    // react quill
    const [value, setValue] = useState("");
    const modules = {
        toolbar: [
            [{ header: [1, 2, false] }],
            ["bold", "italic", "underline", "strike", "blockquote"],
            [
                { list: "ordered" },
                { list: "bullet" },
                { indent: "-1" },
                { indent: "+1" },
            ],
            ["link", "image"],
            ["clean"],
        ],
    };

    const formats = [
        "header",
        "bold",
        "italic",
        "underline",
        "strike",
        "blockquote",
        "list",
        "bullet",
        "indent",
        "link",
        "image",
    ];

    //react select
    const animatedComponents = makeAnimated();
    const [options, setOptions] = useState([]);

    const submit = () => {
        const data = new FormData();
        data.append("name", name);
        data.append("file", file);
        data.append("description", value);
        data.append("category", JSON.stringify(category));
        data.append("user_id", window.auth.id);
        setLoad(true);
        cusaxios.post("/api/article-create", data).then(({ data }) => {
            if (data.success) {
                setLoad(false);
                showToast("Article created", "success");
                navigate("/");
            } else {
                setLoad(false);
                setError(data.data);
            }
        });
        console.log(res);
    };
    const fileChange = (event) => {
        setFile(event.target.files[0]);
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

    useEffect(() => {
        fetchCategory();
    }, []);
    return (
        <Fragment>
            <div className="row">
                <div className="col-sm-9">
                    {load && (
                        <div className="container mt-5">
                            <Spinner />
                        </div>
                    )}
                    {!load && (
                        <div className="card mt-3">
                            <div className="card-header bg-dark">
                                <h4 className="text-white">Create Article</h4>
                            </div>
                            <div className="card-body">
                                <div className="form-group">
                                    <label htmlFor="" className="text-dark">
                                        Enter article name
                                    </label>
                                    <input
                                        type="text"
                                        value={name}
                                        onChange={(e) =>
                                            setName(e.target.value)
                                        }
                                        className={`form-control ${
                                            error && error.name
                                                ? "border border-danger"
                                                : ""
                                        }`}
                                    />
                                    {error && error.name && (
                                        <p className="text-danger">
                                            {error.name[0]}
                                        </p>
                                    )}
                                </div>
                                <div className="form-group">
                                    <label
                                        className="mt-2 text-dark"
                                        htmlFor="customFile"
                                    >
                                        Upload video below 20MB or an image
                                    </label>
                                    <input
                                        type="file"
                                        name="file"
                                        onChange={fileChange}
                                        className="form-control mt-2"
                                        id="customFile"
                                    />
                                    {error && error.file && (
                                        <p className="text-danger">
                                            {error.file[0]}
                                        </p>
                                    )}
                                </div>

                                <div className="form-group mt-3">
                                    <label
                                        htmlFor=""
                                        className="text-dark mb-2"
                                    >
                                        Enter article description
                                    </label>
                                    <ReactQuill
                                        name="description"
                                        theme="snow"
                                        value={value}
                                        onChange={setValue}
                                        modules={modules}
                                        formats={formats}
                                    />
                                    {error && error.description && (
                                        <p className="text-danger">
                                            {error.description[0]}
                                        </p>
                                    )}
                                </div>

                                <div className="form-group mt-3">
                                    <label
                                        htmlFor=""
                                        className="text-dark mb-2"
                                    >
                                        Choose article category
                                    </label>
                                    <Select
                                        closeMenuOnSelect={false}
                                        components={animatedComponents}
                                        // defaultValue={[options[2], options[0]]}
                                        isMulti
                                        options={options}
                                        onChange={setCategory}
                                    />
                                    {error && error.category && (
                                        <p className="text-danger">
                                            {error.category[0]}
                                        </p>
                                    )}
                                </div>

                                <button
                                    onClick={submit}
                                    className="btn btn-success mt-3"
                                >
                                    <i
                                        className="fa-solid fa-plus"
                                        style={{ marginRight: 3, fontSize: 16 }}
                                    />
                                    Create
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </Fragment>
    );
};

export default ArticleCreate;
