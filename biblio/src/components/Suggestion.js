import { Link } from "react-router-dom";

function Suggestion({
  suggestion,
  setBook,
  setSearchTerm,
  setListSuggestions,
  navigation,
}) {
  return (
    <Link
      key={suggestion.id}
      className="p-2 hover:bg-[#096969] text-white hover:cursor-pointer"
      onMouseDown={(event) => {
        event.preventDefault();
        setBook(suggestion);
        setSearchTerm(suggestion.intituleAuteur);
        setListSuggestions([]);
        navigation("/results");
      }}
    >
      {suggestion.intituleAuteur.length > 20 ? (
        <p>{suggestion.intituleAuteur.substr(0, 20)}...</p>
      ) : (
        <p>{suggestion.intituleAuteur}</p>
      )}
    </Link>
  );
}

export default Suggestion;
