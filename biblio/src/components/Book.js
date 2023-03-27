import React, { Fragment } from "react";
import pasDeCouv from "../assets/pas-de-couv.png";

function Book({ props }) {
  return (
    <Fragment>
      <div className="flex flex-col items-center " style={{ width: "15vw" }}>
        {props.couverture !== null ? (
          <img
            src={props.couverture}
            alt="book"
            style={{
              width: "125px",
              height: "175px",
              border: "1.5px solid #009999",
              borderRadius: "5px",
            }}
          />
        ) : (
          <img
            src={pasDeCouv}
            alt="book"
            style={{
              width: "125px",
              height: "175px",
              border: "1.5px #009999 solid",
              borderRadius: "5px",
            }}
          />
        )}
        <p className="m-2">
          {props.titre.length > 20
            ? props.titre.substr(0, 20) + "..."
            : props.titre}
        </p>
      </div>
    </Fragment>
  );
}

export default Book;
