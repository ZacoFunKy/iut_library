import { useState, useEffect } from "react";
import Ami from "./Ami";

function FriendsView() {
  const [friends, setFriends] = useState([]);
  const [recommandations, setRecommandations] = useState([]);

  // fais la meme requete que au dessus mais en fetch
  useEffect(() => {
    fetch("https://localhost:8000/api/amis", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        token: localStorage.getItem("token"),
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

  // mettre des recommandations d'amis avec interrogation api
  useEffect(() => {
    fetch("https://localhost:8000/api/recommandation", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        token: localStorage.getItem("token"),
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        setRecommandations(data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setRecommandations]);

  return (
    <div className="friends-view">
      <div className="h-96">
        <h1>Liste des amis</h1>
        {friends.length > 0 && friends !== undefined ? (
          <div className="flex flex-row flex-wrap justify-left m-10">
            {friends.map((item) => {
              return (
                <Ami item={item} key={item.email} setFriends={setFriends} />
              );
            })}
          </div>
        ) : (
          <div className="w-60">
            <p className="m-auto w-full h-full text-center">Aucun ami pour l'instant</p>
          </div>
        )}
      </div>
      <div className="h-96">
        <h1>Recommandations</h1>
        {recommandations.length > 0 && recommandations !== undefined ? (
          <div className="flex flex-row flex-wrap justify-left m-10">
            {recommandations.map((item) => {
              return (
                <Ami item={item} key={item.email} setRecommandations={setRecommandations} />
              );
            })}
          </div>
        ) : null}
        ;
      </div>
    </div>
  );
}

export default FriendsView;
