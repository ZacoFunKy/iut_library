import { Fragment } from "react";
import { useState } from "react";

function Connexion() {
  const [formData, setFormData] = useState({
    username: "",
    password: "",
  });

  const handleChange = (event) => {
    setFormData({ ...formData, [event.target.name]: event.target.value });
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    console.log(formData);
  };

  return (
    <Fragment>
      <div className="flex justify-center text-[#009999]">
        <form className="pt-6">
          <div className="mb-4 ">
            <h2 className="block  text-4xl font-bold mb-4 text-center">
              Connexion
            </h2>
            <input
              className="border-gray-300 placeholder-[#009999] appearance-none border rounded w-full py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
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
              className="border-gray-300 placeholder-[#009999] appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
              id="password"
              name="password"
              type="password"
              placeholder="Mot de passe"
              value={formData.password}
              onChange={handleChange}
            />
          </div>
          <div className="flex items-center justify-between">
            <button
              className="bg-[#009999] hover:bg-[#086969] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              type="button"
              onClick={handleSubmit}
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
