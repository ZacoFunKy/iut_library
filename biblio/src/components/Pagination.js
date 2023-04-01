function Pagination({ indexPage, setIndex, nbLivres }) {
  const nextPage = () => {
    setIndex(indexPage + 8);
  };

  // page navigation précédente
  const previousPage = () => {
    setIndex(indexPage - 8);
  };

  return (
    <div className="flex justify-around p-3">
      {indexPage === 0 ? null : (
        <button onClick={previousPage} className="flex items-center">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="24"
            height="24"
          >
            <path fill="none" d="M0 0h24v24H0z" />
            <path d="M12 13v7l-8-8 8-8v7h8v2z" />
          </svg>
          Précédent
        </button>
      )}
      <p>Page {indexPage / 8 + 1}</p>
      {nbLivres - 8 * (indexPage / 8 + 1) <= 0 ? null : (
        <button onClick={nextPage} className="flex items-center">
          Suivant
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="24"
            height="24"
          >
            <path fill="none" d="M0 0h24v24H0z" />
            <path d="M12 13H4v-2h8V4l8 8-8 8z" />
          </svg>
        </button>
      )}
    </div>
  );
}

export default Pagination;
