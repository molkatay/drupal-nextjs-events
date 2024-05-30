import React from "react";
import {MenuMain} from "./menu--main";
import Link from "next/link"
import Image from "next/image"
import Button from "../Button";
import {absoluteUrl,  loaderProp} from "lib/utils"


const Navbar = ( { menus, siteInfos, ...props }) => {

  return (
      <nav
          className="flexBetween max-container padding-container relative z-30 py-5">

          <Link
              href="/"
              className="flex items-center mb-4 space-x-2 no-underline md:mb-0"
          >
              <Image src={absoluteUrl(siteInfos.logo)}  loader={loaderProp} alt={siteInfos.name} width={120} height={30}/>

          </Link>
          {menus?.main && <MenuMain menu={menus.main}/>}
          <div className="lg:flexCenter hidden">
              <Button type="button"
                      icon="/user.svg" variant="btn_dark_green"
                      title="Login"
              />

          </div>

          <Image src="menu.svg" alt="menu" width={32} height={32}
                 className="inline-block cursor-pointer lg:hidden"/>
      </nav>
  )
}

export default Navbar;
