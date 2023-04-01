function Auteur({ aut }) {
  return (
    <div key={aut.id}>
      {aut.intituleAuteur !== null ? (
        <div className="book__author text-lg">
          <span className="text-[#009999]">{aut.intituleAuteur}</span>
        </div>
      ) : null}
    </div>
  );
}
export default Auteur;
