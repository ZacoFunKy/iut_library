import pasDeCouv from "../assets/pas-de-couv.png";

function Ami(item, setFriends) {
  // fonction qui permet de supprimer un ami
  const deleteFriend = (email) => {
    fetch("https://localhost:8000/api/amis/delete", {
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
        console.log(data);
        setFriends(data);
      })
      .catch((error) => {
        console.log(error);
      });
    window.location.reload();
  };

  const addFriend = (email) => {
    return (
      <div
        className="w-60 m-5 h-64 flex-col flex justify-between bg-opacity-10 bg-slate-400 p-5 rounded-xl text-center"
        key={item.item.email}
      >
        <h1 className="text-xl text-center  text-[#009999]">
          {item.item.prenomLecteur} {item.item.nomLecteur}
        </h1>
        {item.item.emprunts.length === 0 ? (
          <p className="text-md">Aucun livre emprunté</p>
        ) : (
          <div className="flex">
            {item.item.emprunts.map((emprunt) => {
              return (
                <div
                  className="w-60 text-xs text-center flex flex-col items-center"
                  key={emprunt.livre.titre}
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
        <div>
          <button
            type="button"
            className="bg-red-600 hover:bg-red-500 p-1.5 pl-2 pr-2 rounded-md"
            onClick={() => deleteFriend(item.item.email)}
          >
            Supprimer
          </button>
          <button
            type="button"
            className="bg-green-600 hover:bg-green-500 p-1.5 pl-2 pr-2 rounded-md"
            onClick={() => addFriend(item.item.email)}
          >
            Ajouter
          </button>
        </div>
      </div>
    );
  };
}

export default Ami;
