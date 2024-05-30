import {DrupalNode} from "next-drupal"
import { getMenus } from 'lib/get-menus';

import { drupal } from "lib/drupal"
import { Layout } from "components/layout"
import React from "react";
import Hero from "../components/Hero";
import Features from "../components/Features";
import GetApp from "../components/GetApp";
import Camp from "../components/Camp";
import Guide from "../components/Guide";
import Articles from "../components/Articles";
import Events from "../components/Events";
import {getSiteInfos} from "../lib/get-site-infos";

interface IndexPageProps {
  nodes: DrupalNode[],
events: DrupalNode[],
    siteInfos:any[]
menus: any,
}


export default function IndexPage({ menus, nodes, events, siteInfos }: IndexPageProps) {

  // @ts-ignore
    return (
        <Layout title="Home" menus={menus} siteInfos={siteInfos}>

            <Hero/>
            <Camp/>
            <Guide/>
            <Features/>
            <GetApp/>

            <Articles nodes={nodes}/>
            <Events events={events}/>

        </Layout>
    )
}

export async function getStaticProps(
    context
): Promise<{
    props: { nodes: any; menus: { main: []; footer: [] }; events: any; siteInfos:[]; }
}> {

    const nodes = await drupal.getResourceCollectionFromContext<DrupalNode[]>(
        "node--article",
        context,
        {
            params: {
                "filter[status]": 1,
                "fields[node--article]": "title,path,field_image,uid,created,body",
                "fields[taxonomy_term--tags]": "id,name",
                include: "field_tags,field_image.field_media_image,uid",
                sort: "-created",
                "page[limit]": 3
            },
        }
    )
    const events = await drupal.getResourceCollectionFromContext<DrupalNode[]>(
        "node--event",
        context,
        {
            params: {
                "filter[status]": 1,
                "fields[node--event]": "title,path,uid,field_event_date,body",
                include: "field_image.field_media_image,uid",
                sort: "-field_event_date",
                "page[limit]": 3
            },
        }
    )


    return {
        props: {
            menus: await getMenus(context),
            siteInfos: await getSiteInfos(context),
            nodes,
            events,

    },
  }
}
