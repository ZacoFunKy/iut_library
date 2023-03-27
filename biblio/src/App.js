import { BrowserRouter, Router, Routes, Route, Navigate, useLocation } from "react-router-dom";
import Header from "./components/Header";
import Home from "./components/Home";
import SearchResults from "./components/SearchResults";
import FriendsView from "./components/FriendsView";
import Connexion from "./components/Connexion";
import Footer from "./components/Footer";
import BookView from "./components/BookView";
import { useState, useEffect } from "react";

function App() {
  const [results, setResults] = useState([]);
  const [Book, setBook] = useState([]);
  const [searchTerm, setSearchTerm] = useState("");
  

  return (
    <BrowserRouter basename="/">
      <Header
        searchTerm={searchTerm}
        setSearchTerm={setSearchTerm}
        Book={Book}
        setBook={setBook}
        setResults={setResults}
      />
      <Routes>
        <Route path="/" element={<Home setBook={setBook} />} />
        <Route path="/book" element={<BookView Book={Book}  />} />
        <Route path="/results" element={<SearchResults results={results} setBook={setBook} setSearchTerm={setSearchTerm}  />} />
        <Route path="/amis" element={<FriendsView />} />
        <Route path="/connexion" element={<Connexion />} />
        <Route path="*" element={<Navigate to="/" />} />
      </Routes>
      <Footer />
    </BrowserRouter>
  );
}

export default App;
