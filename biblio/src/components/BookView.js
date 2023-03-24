import { Fragment } from "react";

function BookView({ Book }) {
  console.log(Book);

  return (
    <Fragment>
      {Book.length !== 0 ? (
        <div className="flex flex-col items-center">
          {Book.volumeInfo.title !== null &&
          Book.volumeInfo.title.length > 30 ? (
            <div className="w-max text-2xl md:text-3xl m-3 ml-5">
              {Book.volumeInfo.title.substr(0, 30)}...
            </div>
          ) : null}
          {Book.volumeInfo.title !== null &&
          Book.volumeInfo.title.length <= 30 ? (
            <div className="w-max text-2xl md:text-3xl m-3 ml-5">
              {Book.volumeInfo.title}
            </div>
          ) : null}
          <div className="book m-5 md:flex-row flex-col flex">
            {Book.volumeInfo.thumbnail !== undefined ? (
              <div>
                {Book.volumeInfo.thumbnail !== null ? (
                  <div className="book__image">
                    <img
                      src={Book.volumeInfo.imageLinks.thumbnail}
                      alt="couverture du livre"
                      style={{ minWidth: "400px", height: "65vh" }}
                    />
                  </div>
                ) : (
                  <p>Pas d'image disponible</p>
                )}
              </div>
            ) : null}
            <div className=" ml-0 md:ml-20">
              {Book.volumeInfo.authors !== null ? (
                <div className="book__author text-xl">
                  <span>Auteur : </span>
                  <span className="text-[#009999]">
                    {Book.volumeInfo.authors}
                  </span>
                </div>
              ) : null}
              <div>
                <span className="text-xl">Nombre de pages : </span>{" "}
                {Book.volumeInfo.pageCount === undefined ? (
                  <span className="text-[#009999]">
                    {Book.volumeInfo.pageCount}
                  </span>
                ) : (
                  <p>Pas défini</p>
                )}
              </div>
              {Book.volumeInfo.description !== null ? (
                <div className="flex flex-col max-w-sm">
                  <span className="text-2xl">Résumé</span>
                  <p>{Book.volumeInfo.description.substr(0, 200)}...</p>
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
