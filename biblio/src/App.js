import "./App.css";
import { React, useState } from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import FriendsView from "./components/FriendsView";
import Connexion from "./components/Connexion";
import Header from "./components/Header";
import Footer from "./components/Footer";
import SearchResults from "./components/SearchResults";
import Home from "./components/Home";

function App() {

  const [searchTerm, setSearchTerm] = useState("");

  return (
    <BrowserRouter basename="/">
      <Header searchTerm={searchTerm} setSearchTerm={setSearchTerm} />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/results" element={<SearchResults searchTerm={searchTerm} setSearchTerm={setSearchTerm} />} />
        <Route path="/amis" element={<FriendsView />} />
        <Route path="/connexion" element={<Connexion />} />
      </Routes>
      <Footer />
    </BrowserRouter>
  );
}

export default App;
