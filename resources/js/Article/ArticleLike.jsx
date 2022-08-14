import React, { Fragment, useState, useEffect } from "react";
import { cusaxios } from "../config";

const ArticleLike = () => {
    const [like, setLike] = useState();
    const article_slug = window.article_slug;

    const likeArticle = () => {
        if (like == false) {
            setLike(true);
        } else {
            setLike(false);
        }
        const data = new FormData();
        data.append("article_slug", article_slug);
        data.append("user_id", window.auth.id);
        cusaxios.post("/api/article-like-click", data).then(({ data }) => {
            if (data.success) {
                setLike(data.data);
            }
        });
    };

    useEffect(() => {
        const data = new FormData();
        data.append("article_slug", article_slug);
        data.append("user_id", window.auth.id);
        cusaxios.post("/api/article-like", data).then(({ data }) => {
            if (data.success) {
                setLike(data.data);
            }
        });
    }, []);

    return (
        <Fragment>
            <h1 className="text-danger">
                <i
                    className={`fa-${like ? "solid" : "regular"} fa-heart`}
                    onClick={() => {
                        likeArticle();
                    }}
                ></i>
            </h1>
        </Fragment>
    );
};

export default ArticleLike;
