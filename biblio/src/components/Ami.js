import pasDeCouv from "../assets/pas-de-couv.png";

function Ami({ item, setFriends, friends }) {
  const deleteFriend = (email) => {
    fetch("http://185.212.226.191:8000/api/amis/delete", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: localStorage.getItem("email"),
        emailAmi: email,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        setFriends(data);
      })
      .catch((error) => {
        console.log(error);
      });
    window.location.reload();
  };

  const addFriend = (email) => {
    console.log(email);
    fetch("http://185.212.226.191:8000/api/amis/add", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: localStorage.getItem("email"),
        emailAmi: email,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        setFriends(data);
      })

      .catch((error) => {
        console.log(error);
      });
    window.location.reload();
  };

  return (
    <div
      className="w-60 m-5 mt-0  min-h-64 h-100 flex-col flex justify-between bg-opacity-10 bg-slate-400 p-5 rounded-xl text-center"
      key={item.email}
    >
      <div className="flex items-center mb-2">
        {item.imageDeProfil === null ? (
          <img
            src={pasDeCouv}
            alt="pas-de-couv"
            className="h-12 w-12 mr-2 border-[#009999] rounded border-1"
          ></img>
        ) : (
          <img
            src={item.imageDeProfil}
            alt="couv"
            className="h-12 w-12 mr-2 border-[#009999] rounded border-2"
          ></img>
        )}

        <h1 className="text-xl text-center  text-[#009999]">
          {item.prenomLecteur} {item.nomLecteur}
        </h1>
      </div>
      {item.emprunts.length === 0 ? (
        <p className="text-md">Aucun livre emprunté</p>
      ) : (
        <div className="flex">
          {item.emprunts.map((emprunt) => {
            return (
              <div
                className="w-60 text-xs text-center flex flex-col items-center"
                key={emprunt.livre.id}
              >
                {emprunt.livre.couverture === null ? (
                  <img
                    src={pasDeCouv}
                    alt="pas-de-couv"
                    width="50px"
                    className="h-20 border-black rounded border-1"
                  ></img>
                ) : (
                  <img
                    src={emprunt.livre.couverture}
                    alt="couv"
                    width="50px"
                    className="h-20 border-black rounded border-2"
                  ></img>
                )}
                <div className="mt-2">
                  {emprunt.livre.titre.length > 20
                    ? emprunt.livre.titre.substr(0, 20) + "..."
                    : emprunt.livre.titre}
                </div>
              </div>
            );
          })}
        </div>
      )}
      <div className=" flex justify-around mt-2">
        {friends.find((friend) => friend.email === item.email) ? (
          <button
            type="button"
            className="bg-red-600 hover:bg-red-500 p-1.5 pl-2 pr-2 rounded-md w-max"
            onClick={() => deleteFriend(item.email)}
          >
            Supprimer
          </button>
        ) : null}

        {friends.find((friend) => friend.email === item.email) ? null : (
          <button
            type="button"
            className="bg-green-600 hover:bg-green-500 p-1.5 pl-2 pr-2 rounded-md w-max"
            onClick={() => addFriend(item.email)}
          >
            Ajouter
          </button>
        )}
      </div>
    </div>
  );
}

export default Ami;
