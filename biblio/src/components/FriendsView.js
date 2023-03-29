import { useState, useEffect } from "react";
import axios from "axios";

function FriendsView() {
  const [friends, setFriends] = useState([]);

  // recupere les amis du lecteur courant avec son email en post
  useEffect(() => {
    axios
      .post("https://localhost:8000/api/amis", {
        email: localStorage.getItem("email"),
      })
      .then((response) => {
        console.log(response.data);
        setFriends(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setFriends]);

  return (
    <div className="friends-view">
      <h1>Liste des amis</h1>
      {friends.length > 0 && friends !== undefined ? (
        <div className="flex flex-row justify-center">
          {friends.map((item) => {
            return (
              <div className="w-60" key={item.email}>
                <h1>{item.prenomLecteur} {item.nomLecteur}</h1>
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
