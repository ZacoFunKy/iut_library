import React from "react";
import pasDeCouv from "../assets/pas-de-couv.png";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";

function Book({ props, setBook }) {
  const navigation = useNavigate();

  return (
    <Link
      onMouseDown={(event) => {
        event.preventDefault();
        navigation(`/book`);
        setBook(props);
      }}
    >
      <div className="max-w-64 w-64 min-w-64">
        <p className="m-2 text-center">
          {props.titre.length > 20
            ? props.titre.substr(0, 20) + "..."
            : props.titre}
        </p>
        <div className="flex flex-row items-center m-auto min-w-32 max-w-32 ">
          {props.couverture !== undefined && props.couverture !== null ? (
            <img
              src={props.couverture}
              alt="book"
              className="border-2 border-[#009999] rounded-md h-48 w-32 object-cover"
            />
          ) : (
            <img
              src={pasDeCouv}
              alt="book"
              className="border-2 border-[#009999] rounded-md h-48 min-w-32 w-32 object-cover"
            />
          )}

          <div>
            <div className="m-2 text-left">
              <p className="text-md">Par</p>
              {props.auteurs.length === 0 ? (
                <p className="text-md">Pas d'auteurs définis</p>
              ) : (
                <p className="text-sm text-[#009999]">
                  {props.auteurs[0].intituleAuteur.split("(")[0]}
                </p>
              )}
            </div>
            <div className="m-2">
              {props.dateParution === null || props.dateParution === undefined ? (
                <p className="text-md">Pas de date définie</p>
              ) : (
                <p className="text-md">{props.dateParution.split("-")[0]}</p>
              )}
            </div>
          </div>
        </div>
      </div>
    </Link>
  );
}

export default Book;
