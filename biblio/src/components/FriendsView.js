import { useState, useEffect } from "react";
import axios from "axios";
import pasDeCouv from "../assets/pas-de-couv.png";

function FriendsView() {
  const [friends, setFriends] = useState([]);


  // fais la meme requete que au dessus mais en fetch
   useEffect(() => {
    fetch("https://localhost:8000/api/amis", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: localStorage.getItem("email"),
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        setFriends(data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setFriends]);


  return (
    <div className="friends-view">
      <h1>Liste des amis</h1>
      {friends.length > 0 && friends !== undefined ? (
        <div className="flex flex-row flex-wrap justify-left m-10">
          {friends.map((item) => {
            return (
              <div className="w-60 m-5" key={item.email}>
                <h1 className="text-xl text-center text-[#009999]">
                  {item.prenomLecteur} {item.nomLecteur}
                </h1>
                <div className="flex">
                  {item.emprunts.map((emprunt) => {
                    return (
                      <div className="w-60" key={emprunt.livre.titre}>
                        {emprunt.livre.titre.length > 20
                          ? emprunt.livre.titre.substr(0, 20) + "..."
                          : emprunt.livre.titre}
                        {emprunt.livre.couverture === null ? (
                          <img src={pasDeCouv} alt="pas-de-couv" width="50px"></img>
                        ) : (
                          <img
                            src={emprunt.livre.couverture}
                            alt="couv"
                            width="50px"
                          ></img>
                        )}
                      </div>
                    );
                  })}
                </div>
              </div>
            );
          })}
        </div>
      ) : (
        <div className="w-60">
          <p>Aucun ami pour l'instant</p>
        </div>
      )}
    </div>
  );
}

export default FriendsView;
