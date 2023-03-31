import {
  BrowserRouter,
  Routes,
  Route,
  Navigate,
} from "react-router-dom";
import Header from "./components/Header";
import Home from "./components/Home";
import SearchResults from "./components/SearchResults";
import FriendsView from "./components/FriendsView";
import Connexion from "./components/Connexion";
import Footer from "./components/Footer";
import BookView from "./components/BookView";
import { useState } from "react";

function App() {
  const [results, setResults] = useState([]);
  const [Book, setBook] = useState([]);
  const [searchTerm, setSearchTerm] = useState("");
  const [indexPage, setIndex] = useState(0);
  const [nbLivres, setNbLivres] = useState(0);
  const [textSearch, setTextSearch] = useState("Aucune recherche");

  return (
    <BrowserRouter basename="/">
      <Header
        searchTerm={searchTerm}
        setSearchTerm={setSearchTerm}
        Book={Book}
        setBook={setBook}
        setResults={setResults}
        indexPage={indexPage}
        setIndex={setIndex}
        setNbLivres={setNbLivres}
        setTextSearch={setTextSearch}

      />
      <div className="content">
        <Routes>
          <Route path="/" element={<Home setBook={setBook} />} />
          <Route path="/book" element={<BookView Book={Book} />} />
          <Route
            path="/results"
            element={
              <SearchResults
                indexPage={indexPage}
                setIndex={setIndex}
                results={results}
                setBook={setBook}
                setSearchTerm={setSearchTerm}
                nbLivres={nbLivres}
                textSearch={textSearch}
              />
            }
          />
          <Route path="/amis" element={<FriendsView />} />
          <Route path="/connexion" element={<Connexion />} />
          <Route path="*" element={<Navigate to="/" />} />
        </Routes>
      </div>

      <Footer />
    </BrowserRouter>
  );
}

export default App;
