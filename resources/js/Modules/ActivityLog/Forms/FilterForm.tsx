import React from "react";
import { Button, Flex, Modal, Radio, Stack, Text, TextInput, Group } from "@mantine/core";
import { IconFilter } from "@tabler/icons-react";
import { useDisclosure } from "@mantine/hooks";

interface FilterFormProps { }

const FilterForm: React.FC<FilterFormProps> = () => {
    const [opened, { open, close }] = useDisclosure(false);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        close();
    };

    return (
        <>
            <Button
                variant="subtle"
                color="dark.3"
                leftSection={<IconFilter size={18} />}
                onClick={open}
            >
                Filter
            </Button>

            <Modal
                opened={opened}
                onClose={close}
                title={
                    <Text fw="bold" size="lg">
                        Filter Activity Log
                    </Text>
                }
                size="550"
            >
                <form onSubmit={handleSubmit}>
                    <Stack gap={16}>
                        <TextInput
                            placeholder="Search"
                            leftSection={<IconFilter size={18} />}
                        // value={search}
                        // onChange={(e) => setSearch(e.target.value)}
                        />

                        <Radio.Group name="actionType" label="Action Type" defaultValue="">
                            <Group mt="xs">
                                <Radio value="created" label="Created" />
                                <Radio value="updated" label="Updated" />
                                <Radio value="deleted" label="Deleted" />
                                <Radio value="" label="All" />
                            </Group>
                        </Radio.Group>
                    </Stack>

                    <Flex align="center" justify="end" mt={16}>
                        <Button variant="outline" onClick={close}>
                            Cancel
                        </Button>

                        <Button ml={12} type="submit">
                            Apply Filters
                        </Button>
                    </Flex>
                </form>
            </Modal>
        </>
    );
};

export default FilterForm;