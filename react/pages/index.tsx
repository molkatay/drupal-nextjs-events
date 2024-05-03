import { GetStaticPropsResult } from "next"
import {DrupalNode, DrupalUser} from "next-drupal"
import { getMenus } from 'lib/get-menus';

import { drupal } from "lib/drupal"
import { Layout } from "components/layout"
import { NodeArticleTeaser } from "components/node--article--teaser"
import { NodeEventTeaser } from "components/node--event--teaser"
import { User } from "components/user"
import React from "react";

interface IndexPageProps {
  nodes: DrupalNode[],
    events: DrupalNode[],
    menus: any
}


export default function IndexPage({ menus, nodes, users, events }: IndexPageProps) {


  // @ts-ignore
    return (
        <Layout title="Home" menus={menus}>
            <div>
                <h1 className="mb-10 text-6xl font-black">Latest Articles.</h1>
                {nodes?.length ? (
                    nodes.map((node) => (
                        <div key={node.id}>
                            <NodeArticleTeaser node={node}/>
                            <hr className="my-20"/>
                        </div>
                    ))
                ) : (
                    <p className="py-4">No nodes found</p>
                )}
            </div>
            <div>
                <h1 className="mb-10 text-6xl font-black">Latest events.</h1>
                {events?.length ? (
                    events.map((node) => (
                        <div key={node.id}>
                            <NodeEventTeaser node={node}/>
                            <hr className="my-20"/>
                        </div>
                    ))
                ) : (
                    <p className="py-4">No events found</p>
                )}
            </div>
        </Layout>
    )
}

export async function getStaticProps(
    context
): Promise<{ props: { nodes: any; menus: { main: []; footer: [] }; users: any } }> {

    const nodes = await drupal.getResourceCollectionFromContext<DrupalNode[]>(
        "node--article",
        context,
        {
            params: {
                "filter[status]": 1,
                "fields[node--article]": "title,path,field_image2,uid,created",
                include: "field_image2,uid",
                sort: "-created",
      },
    }
  )
    const events = await drupal.getResourceCollectionFromContext<DrupalNode[]>(
        "node--event",
        context,
        {
            params: {
                "filter[status]": 1,
                "fields[node--event]": "title,path,uid,created",
                include: "uid",
                sort: "-created",
            },
        }
    )
    return {
    props: {
       menus: await getMenus(context),
        nodes,
        events
    },
  }
}
