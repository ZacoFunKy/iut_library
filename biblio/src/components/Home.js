import { React, useEffect, useState } from "react";
import Book from "./Book";

function Home({ setBook }) {
  const [derniersLivres, setDerniersLivres] = useState([]);
  const [derniersEmprunts, setDerniersEmprunts] = useState([]);

  // fasi pareil que au dessus mais avec fetch
  useEffect(() => {
    fetch("http://185.212.226.191:8000/api/books/last_posts")
      .then((response) => response.json())
      .then((data) => {
        setDerniersLivres(data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setDerniersLivres]);

  // fais pareil que au dessus mais avec un bearer token
  useEffect(() => {
    fetch("http://185.212.226.191:8000/api/lastEmprunt", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        // mettre le bearer token
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      body: JSON.stringify({
        token: localStorage.getItem("token"),
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        setDerniersEmprunts(data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setDerniersEmprunts]);



  return (
    <div className="home relative">
      <div className="derniers-emprunts m-20 h-auto items-center">
        <h2 className="md:text-xl text-lg">Derniers livres empruntés</h2>
        {derniersEmprunts.length > 0 && derniersEmprunts !== undefined? (
          <div className="flex flex-row flex-wrap justify-around">
            {derniersEmprunts.map((item) => {
              return (
                <div key={item.livre.id}>
                  <Book props={item.livre} setBook={setBook} />
                </div>
              );
            })}
          </div>
        ) : (
          <p className=" w-100 text-center m-40">Aucun livre emprunté pour l'instant</p>
        )}
      </div>
      <div className="derniers-ajout m-20 h-min">
        <h2 className="md:text-xl text-lg">Derniers livres ajoutés</h2>
        {derniersLivres !== undefined && derniersLivres.length > 0 ? (
          <div className="flex flex-row flex-wrap justify-around m-5">
            {derniersLivres.map((livre) => {
                return (
                <div key={livre.id}>
                  <Book props={livre} setBook={setBook} />
                </div>
                );
            })}
          </div>
        ) : null}
      </div>
    </div>
  );
}

export default Home;
