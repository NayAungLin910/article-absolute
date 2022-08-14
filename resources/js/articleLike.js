import React from "react";
import { createRoot } from "react-dom/client";
import { HashRouter, Routes, Route } from "react-router-dom";
import ArticleLike from "./Article/ArticleLike";

const MainRouter = () => {
    return (
        <HashRouter>
            <Routes>
                <Route path="/" element={<ArticleLike />} />
            </Routes>
        </HashRouter>
    )
};

createRoot(document.getElementById("root")).render(<MainRouter />);
