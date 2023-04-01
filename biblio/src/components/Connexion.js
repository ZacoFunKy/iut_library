import { Fragment } from "react";
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";

function Connexion() {
  const navigation = useNavigate();
  const [formData, setFormData] = useState({
    username: "",
    password: "",
  });

  const handleChange = (event) => {
    setFormData({ ...formData, [event.target.name]: event.target.value });
  };

  const login = (event) => {
    event.preventDefault();
    axios
      .post("http://185.212.226.191:8000/api/login", {
        username: formData.username,
        password: formData.password,
      })
      .then((response) => {
        // on stocke le token dans le local storage
        localStorage.setItem("token", response.data.token);
        localStorage.setItem("email", response.data.email);
        // on redirige vers la page d'accueil
        navigation("/");
      })
      .catch((error) => {
        console.log(error);
        alert("Email ou mot de passe incorrect")
      });
  }

  return (
    <Fragment>
      <div className="flex justify-center text-[#009999]">
        <form className="pt-6">
          <div className="mb-4 ">
            <h2 className="block  text-4xl font-bold mb-4 text-center">
              Connexion
            </h2>
            <input
              className="border-gray-300 appearance-none border rounded w-full py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
              id="username"
              name="username"
              type="text"
              placeholder="Nom"
              value={formData.username}
              onChange={handleChange}
            />
          </div>
          <div className="mb-6">
            <input
              className="border-gray-300 appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
              id="password"
              name="password"
              type="password"
              placeholder="Mot de passe"
              value={formData.password}
              onChange={handleChange}
            />
          </div>
          <div className="flex items-center justify-center">
            <button
              className="bg-[#009999] hover:bg-[#086969] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              type="button"
              onClick={login}
            >
              Se connecter
            </button>
          </div>
        </form>
      </div>
    </Fragment>
  );
}

export default Connexion;
