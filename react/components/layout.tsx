import {PreviewAlert} from "components/preview-alert"
import {DrupalMenuLinkContent} from "next-drupal";
import React from "react";

import Head from "next/head";
import Navbar from "./layout/Navbar";
import Footer from "./layout/Footer";

export interface LayoutProps {
    title?: string;
    children?: React.ReactNode;
    menus: {
        main: DrupalMenuLinkContent[];
        footer: DrupalMenuLinkContent[];
    };
    siteInfos: {
        name: string;
        slogan: string;
        logo: string;
        favicon: string;
    };
}

export function Layout({title, children, menus, siteInfos}): LayoutProps {
    return (
        <>
            <Head>
                <title>{`${title}`}</title>
            </Head>
            <PreviewAlert/>
            <Navbar menus={menus} siteInfos={siteInfos}/>

            <main className="relative overflow-hidden">{children}</main>

            <Footer menus={menus.footer} siteInfos={siteInfos}/>

        </>
    )
}
