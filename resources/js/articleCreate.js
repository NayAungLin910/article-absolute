import React from "react";
import { createRoot } from "react-dom/client";
import { HashRouter, Routes, Route } from "react-router-dom";
import ArticleCreate from "./Article/ArticleCreate";
import Article from "./Article/Article";
import ArticleNav from "./Article/ArticleNav";
import ArticleDescription from "./Article/ArticleDescription";

const MainRouter = () => {
    return (
        <HashRouter>
            <ArticleNav />
            <Routes>
                <Route path="/create" element={<ArticleCreate />} />
                <Route path="/" element={<Article /> } />
                <Route path="/article" element={<ArticleDescription />} />
            </Routes>
        </HashRouter>
    )
};

createRoot(document.getElementById("root")).render(<MainRouter />);