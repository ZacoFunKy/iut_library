import React, { Fragment } from "react";

function Book({ props }) {
  return (
    <Fragment>
      <div className="flex flex-col items-center" >
        {props.volumeInfo.imageLinks !== undefined ? (
          <img src={props.volumeInfo.imageLinks.thumbnail} alt="book" />
        ) : <p>Pas d'image dispo</p>}
        <p> {props.volumeInfo.title} </p>
      </div>
    </Fragment>
  );
}

export default Book;
