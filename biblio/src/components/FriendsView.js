import { useState, useEffect } from "react";
import Ami from "./Ami";

function FriendsView() {
  const [friends, setFriends] = useState([]);
  const [recommandations, setRecommandations] = useState([]);

  // fais la meme requete que au dessus mais en fetch
  useEffect(() => {
    fetch("http://185.212.226.191:8000/api/amis", {
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
        setFriends(data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setFriends]);

  // mettre des recommandations d'amis avec interrogation api
  useEffect(() => {
    fetch("http://185.212.226.191:8000/api/recommandation", {
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
        setRecommandations(data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setRecommandations]);

  return (
    <div className="friends-view">
      <div className="min-h-96 mt-10 ml-10">
        <h2 className="md:text-xl text-lg">Vos amis</h2>
        {friends.length > 0 && friends !== undefined ? (
          <div className="flex flex-row flex-wrap justify-left m-10 overflow-x-auto">
            {friends.map((item) => {
              return (
                <Ami
                  friends={friends}
                  item={item}
                  key={item.email}
                  setFriends={setFriends}
                />
              );
            })}
          </div>
        ) : (
          <div className="w-60">
            <p className="m-auto w-full h-full overflow-x-auto">
              Aucun ami pour l'instant
            </p>
          </div>
        )}
      </div>
      <div className="min-h-96 ml-10">
        <h2 className="md:text-xl text-lg">Recommandations</h2>
        {recommandations.length > 0 && recommandations !== undefined ? (
          <div className="flex flex-row flex-wrap justify-left m-10">
            {recommandations.map((item) => {
              return (
                <Ami
                  friends={friends}
                  item={item}
                  key={item.email}
                  setFriends={setFriends}
                />
              );
            })}
          </div>
        ) : (
          <div className="w-60">
            <p className="m-auto w-full h-full overflow-x-auto">
              Aucune recommandation
            </p>
          </div>
        )}
      </div>
    </div>
  );
}

export default FriendsView;
