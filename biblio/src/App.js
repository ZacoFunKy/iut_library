import './App.css';

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
