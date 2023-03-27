import React, { Fragment } from "react";

function Book({ props }) {
  return (
    <Fragment>
      <div className="flex flex-col items-center" >
        {props.couverture !== null ? (
          <img src={props.couverture} alt="book" />
        ) : <p>Pas d'image dispo</p>}
        <p> {props.titre} </p>
      </div>
    </Fragment>
  );
}

export default Book;
