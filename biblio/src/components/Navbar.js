import { Link, useLocation } from "react-router-dom";
import { useState } from "react";

function Navbar() {
  const location = useLocation();
  const [showMenu, setShowMenu] = useState(false);

  return (
    <div className="">
      <button
        type="button"
        className="block lg:hidden relative"
        onClick={() => setShowMenu(!showMenu)}
      >
        <svg
          className="h-6 w-6 fill-current"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          {showMenu ? (
            <path
              fillRule="evenodd"
              clipRule="evenodd"
              d="M13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12Z"
            />
          ) : (
            <path
              fillRule="evenodd"
              clipRule="evenodd"
              d="M4 6C4 5.44772 4.44772 5 5 5H19C19.5523 5 20 5.44772 20 6C20 6.55228 19.5523 7 19 7H5C4.44772 7 4 6.55228 4 6ZM4 12C4 11.4477 4.44772 11 5 11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H5C4.44772 13 4 12.5523 4 12ZM5 17C4.44772 17 4 17.4477 4 18C4 18.5523 4.44772 19 5 19H19C19.5523 19 20 18.5523 20 18C20 17.4477 19.5523 17 19 17H5Z"
            />
          )}
        </svg>
      </button>

      {showMenu ? (
      <div className="fixed inset-0 flex items-center justify-center bg-white">
        <div className="lg:hidden flex flex-col items-center">
          <Link
            to="/"
            className={`text text-xl mr-5 ${location.pathname === "/"
              ? "text-[#009999] underline underline-offset-8"
              : "hover:underline underline-offset-8 "
            }`}
          >
            Accueil
          </Link>
          <Link
            to="/amis"
            className={`text text-xl mr-5 ${location.pathname === "/amis"
              ? "text-[#009999] underline underline-offset-8"
              : "hover:underline underline-offset-8 "
            }`}
          >
            Amis
          </Link>
          <Link
            to="/connexion"
            className={`text text-xl mr-5 ${location.pathname === "/connexion"
              ? "text-[#009999] underline underline-offset-8"
              : "hover:underline underline-offset-8"
            }`}
          >
            Connexion
          </Link>
        </div>
      </div>
      ) : (
        <div className="hidden lg:flex flex-row items-center">
          <Link
            to="/"
            className={`text text-xl mr-5 ${location.pathname === "/"
              ? "text-[#009999] underline underline-offset-8"
              : "hover:underline underline-offset-8 "
            }`}
          >
            Accueil
          </Link>
          <Link
            to="/amis"
            className={`text text-xl mr-5 ${location.pathname === "/amis"
              ? "text-[#009999] underline underline-offset-8"
              : "hover:underline underline-offset-8 "
            }`}
          >
            Amis
          </Link>
          <Link
            to="/connexion"
            className={`text text-xl mr-5 ${location.pathname === "/connexion"
              ? "text-[#009999] underline underline-offset-8"
              : "hover:underline underline-offset-8"
            }`}
          >
            Connexion
          </Link>
        </div>
      )}
    </div>
  );
}

export default Navbar;
