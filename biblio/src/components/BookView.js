import { Fragment } from "react";
import pasDeCouv from "../assets/pas-de-couv.png";

function BookView({ Book }) {
  console.log(Book);

  return (
    <Fragment>
      {Book.length !== 0 ? (
        <div className="flex flex-col items-center">
          {Book.titre !== null && Book.titre.length > 30 ? (
            <div className="w-max text-2xl md:text-3xl m-3 ml-5">
              {Book.titre.substr(0, 30)}...
            </div>
          ) : null}
          {Book.titre !== null && Book.titre.length <= 30 ? (
            <div className="w-max text-2xl md:text-3xl m-3 ml-5">
              {Book.titre}
            </div>
          ) : null}
          <div className="book m-5 md:flex-row flex-col flex">
            {Book.couverture !== null ? (
              <div className="book__image border">
                <img
                  src={Book.couverture}
                  alt="couverture du livre"
                  style={{
                    minWidth: "250px",
                    maxWidth: "300px",
                    height: "50vh",
                  }}
                />
              </div>
            ) : (
              <img
                src={pasDeCouv}
                alt="couverture du livre"
                style={{
                  minWidth: "200px",
                  maxHeight: "250px",
                  height: "65vh",
                }}
              />
            )}

            <div className=" ml-0 md:ml-20">
              {Book.auteurs.length !== 0 ? (
                <div>
                  <span>Auteur(s) : </span>
                  {Book.auteurs.map((aut) => {
                    return (
                      <div key={aut.id}>
                        {aut.intituleAuteur !== null ? (
                          <div className="book__author text-xl">
                            <span className="text-[#009999]">
                              {aut.intituleAuteur}
                            </span>
                          </div>
                        ) : null}
                      </div>
                    );
                  })}
                </div>
              ) : null}

              <div>
                <span className="text-xl">Nombre de pages : </span>{" "}
                {Book.page !== undefined ? (
                  <span className="text-[#009999]">{Book.page}</span>
                ) : (
                  <p>Pas défini</p>
                )}
              </div>
              {Book.description !== undefined ? (
                <div className="flex flex-col max-w-sm">
                  <span className="text-2xl">Résumé</span>
                  <p>{Book.description.substr(0, 200)}...</p>
                </div>
              ) : null}
            </div>
          </div>
        </div>
      ) : null}
    </Fragment>
  );
}

export default BookView;
