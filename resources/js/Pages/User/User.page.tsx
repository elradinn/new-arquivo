import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import { IconEdit, IconPlus, IconSearch, IconTrash } from "@tabler/icons-react";
import { ActionIcon, Box, Button, Flex, Group, rem, Stack, Text, TextInput } from "@mantine/core";
import { DataTable } from "mantine-datatable";
import { useDisclosure } from "@mantine/hooks";
import { User, UserPageProps } from "@/types";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import AddUserForm from "./AddUserForm";
import EditUserForm from "./EditUserForm";
import DeleteUserForm from "./DeleteUser";

export default function UserPage({ auth, user, filters }: UserPageProps) {
    const [selectedRecord, setSelectedRecord] = useState<User[]>([]);
    const [currentUser, setCurrentUser] = useState<User | undefined>();

    // const [page, setPage] = useState(user.current_page);
    // const [search, setSearch] = useState(filters.search || "");

    // const handleSearch = (search: string) => {
    //     router.get("/user", { search }, { preserveState: true, replace: true });
    // };

    // const handleonPageChange = (page: number) => {
    //     const newUrl = user.links.find(
    //         (link: { label: string; url: string }) => link.label === page.toString(),
    //     )?.url;
    //     if (newUrl) {
    //         router.visit(newUrl);
    //     }
    // };

    // const [addUserOpened, { open: openAddUser, close: closeAddUser }] = useDisclosure(false);

    // const [editUserOpened, { open: openEditUser, close: closeEditUser }] = useDisclosure(false);

    // const [deleteUserOpened, { open: openDeleteUser, close: closeDeleteUser }] =
    //     useDisclosure(false);

    // const handleEditUser = (user: User) => {
    //     setCurrentUser(user);
    //     openEditUser();
    // };

    // const handleDeleteUser = (user: User) => {
    //     setCurrentUser(user);
    //     openDeleteUser();
    // };

    return (
        <Authenticated>
            <Head title="User" />
            <Stack px={8} gap={24} py={8}>
                <Text component="h2" size="xl" fw={600} c="gray.8">
                    User
                </Text>
                {/* <Flex
                    justify="space-between"
                    direction={{ base: "column", md: "row" }}
                    gap={{ base: 12, md: 0 }}
                >
                    <TextInput
                        w={{ md: 400 }}
                        placeholder="Search"
                        leftSection={
                            <IconSearch style={{ width: rem(16), height: rem(16) }} stroke={1.5} />
                        }
                        value={search}
                        onChange={(e) => {
                            setSearch(e.target.value);
                            handleSearch(e.target.value);
                        }}
                    />
                    <Button leftSection={<IconPlus size={14} />} onClick={openAddUser}>
                        Add New User
                    </Button>
                </Flex>
                <DataTable
                    pinLastColumn
                    withTableBorder
                    shadow="xs"
                    borderRadius="sm"
                    withRowBorders={false}
                    highlightOnHover
                    verticalSpacing="md"
                    totalRecords={user.total}
                    recordsPerPage={user.per_page}
                    page={page}
                    onPageChange={(p) => {
                        setPage(p);
                        handleonPageChange(p);
                    }}
                    columns={[
                        { accessor: "name", noWrap: true },
                        { accessor: "email", noWrap: true },
                        {
                            accessor: "actions",
                            title: <Box mr={6}>Actions</Box>,
                            textAlign: "right",
                            render: (user) => (
                                <Group gap={8} justify="right" wrap="nowrap">
                                    <ActionIcon
                                        size="sm"
                                        variant="subtle"
                                        color="gray"
                                        onClick={() => {
                                            handleEditUser(user);
                                        }}
                                    >
                                        <IconEdit size={48} />
                                    </ActionIcon>
                                    <ActionIcon
                                        size="sm"
                                        variant="subtle"
                                        color="red"
                                        onClick={() => {
                                            handleDeleteUser(user);
                                        }}
                                    >
                                        <IconTrash size={48} />
                                    </ActionIcon>
                                </Group>
                            ),
                        },
                    ]}
                    records={user.data}
                    selectedRecords={selectedRecord}
                    onSelectedRecordsChange={setSelectedRecord}
                /> */}
            </Stack>

            {/* <AddUserForm isOpened={addUserOpened} close={closeAddUser} />

            <EditUserForm isOpened={editUserOpened} close={closeEditUser} user={currentUser} />

            <DeleteUserForm
                isOpened={deleteUserOpened}
                close={closeDeleteUser}
                user={currentUser}
            /> */}
        </Authenticated>
    );
}
