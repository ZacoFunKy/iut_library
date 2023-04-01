import { Fragment } from "react";
import pasDeCouv from "../assets/pas-de-couv.png";
import Auteur from "./Auteur";

function BookView({ Book }) {
  console.log(Book);

  return (
    <Fragment>
      <button
        className="bg-[#009999] ml-10 mt-10 pr-5 pl-5 p-2 retour"
        onClick={() => window.history.back()}
      >
        Retour
      </button>
      {Book.length !== 0 ? (
        <div className="flex flex-col items-center">
          {Book.titre !== null ? (
            <div className="w-2/3 text-center text-2xl md:text-3xl m-3 ml-5">
              {Book.titre}
            </div>
          ) : null}
          <div className="m-5 md:flex-row flex-col flex">
            {Book.couverture !== undefined && Book.couverture !== null ? (
              <div className="flex justify-center mb-5">
                <img
                  src={Book.couverture}
                  alt="couverture du livre"
                  className="border-2 border-[#009999] rounded-md h-96 w-64 object-cover"
                />
              </div>
            ) : (
              <img
                src={pasDeCouv}
                alt="couverture du livre"
                className="border-2 border-[#009999] rounded-md h-96 w-64 object-cover"
              />
            )}

            <div className="ml-0 md:ml-20 flex-col flex justify-around ">
              <div className="text-left flex flex-col ">
                <div className="flex justify-between ">
                  <div className="flex flex-col">
                    <span className="text-xl">Auteur(s) : </span>
                    {Book.auteurs.length !== 0 ? (
                      <div className="w-64 flex flex-col">
                        {Book.auteurs.map((aut) => {
                          return <Auteur aut={aut} key={aut.id} />;
                        })}
                      </div>
                    ) : (
                      <p>Pas défini</p>
                    )}
                  </div>

                  <div className="w-64 flex flex-col">
                    <span className="text-xl">Nombre de pages : </span>
                    {Book.page !== null ? (
                      <span className="text-[#009999]">{Book.page}</span>
                    ) : (
                      <p>Pas défini</p>
                    )}
                  </div>
                </div>
                <div className="flex justify-between mt-7">
                  <div className="w-64">
                    <span className="text-xl">Editeur :</span>
                    {Book.editeur !== undefined && Book.editeur !== null ? (
                      <span className="text-[#009999]">
                        <br></br> {Book.editeur.nomEditeur}
                      </span>
                    ) : (
                      <p>Pas défini</p>
                    )}
                  </div>
                  <div className="w-64">
                    <span className="text-xl">Catégorie(s) :</span>
                    {Book.categories.length > 0 ? (
                      <div>
                        {Book.categories.map((cat) => {
                          return (
                            <div key={cat.id}>
                              <span className="text-[#009999]">
                                {cat.nomCategorie}
                              </span>
                            </div>
                          );
                        })}
                      </div>
                    ) : (
                      <p>Pas défini</p>
                    )}
                  </div>
                </div>
              </div>
              <div>
                {Book.description !== undefined ? (
                  <div className="flex flex-col max-w-sm">
                    <span className="text-2xl">Résumé</span>
                    <p>{Book.description.substr(0, 200)}...</p>
                  </div>
                ) : null}
              </div>
            </div>
          </div>
        </div>
      ) : null}
    </Fragment>
  );
}

export default BookView;
