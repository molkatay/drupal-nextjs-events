import { GetStaticPropsResult } from "next"
import {DrupalNode, DrupalUser} from "next-drupal"
import { getMenus } from 'lib/get-menus';

import { drupal } from "lib/drupal"
import { Layout } from "components/layout"
import { NodeArticleTeaser } from "components/node--article--teaser"
import { User } from "components/user"
import React from "react";

interface IndexPageProps {
  nodes: DrupalNode[],
    users: DrupalUser[],
    menus: any
}

export default function IndexPage({ menus, nodes, users }: IndexPageProps) {
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
              <h1 className="mb-10 text-6xl font-black">List of users</h1>
              {users?.length ? (
                  users.map((user) => (
                      <div key={user.id}>
                          <User user={user}/>
                          <hr className="my-20"/>
                      </div>
                  ))
              ) : (
                  <p className="py-4">No users found</p>
              )}
          </div>
      </Layout>
  )
}

export async function getStaticProps(
    context
): Promise<GetStaticPropsResult<IndexPageProps>> {

    const nodes = await drupal.getResourceCollectionFromContext<DrupalNode[]>(
        "node--article",
        context,
        {
            params: {
                "filter[status]": 1,
                "fields[node--article]": "title,path,field_image,uid,created",
                include: "field_image,uid",
        sort: "-created",
      },
    }
  )
    const users = await drupal.getResourceCollection<DrupalUser[]>("user--user")
  return {
    props: {
        menus: await getMenus(context),
        nodes,
        users
    },
  }
}
